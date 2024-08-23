<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clearance Requests</title>
    <style>
        .container {
            font-family: Arial, sans-serif;
        }

        h2 {
            text-align: left;
            margin-bottom: 20px;
        }

        .search-bar {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
        }

        .search-bar input {
            padding: 10px;
            width: 300px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .student-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .student-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #eee;
            padding: 15px;
            border-radius: 15px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .student-info {
            display: flex;
            align-items: center;
        }

        .student-avatar {
            margin-right: 15px;
        }

        .avatar-placeholder {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #007bff;
        }

        .student-details {
            font-size: 14px;
            color: #333;
        }

        .student-details h3 {
            font-size: 16px;
            margin: 0;
            margin-bottom: 5px;
            color: #007bff;
        }

        .request-info {
            display: flex;
            flex-direction: column;
            gap: 10px;
            text-align: right;
        }

        .status {
            font-size: 14px;
            font-weight: bold;
        }

        .status.approved {
            color: #27ae60;
        }

        .status.declined {
            color: #e74c3c;
        }

        .status.pending {
            color: #f39c12;
        }

        .buttons {
            display: flex;
            gap: 10px;
        }

        .decline,
        .approve {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .decline {
            background-color: #e74c3c;
            color: white;
        }

        .decline.disabled {
            background-color: #95a5a6;
            cursor: not-allowed;
        }

        .decline:hover:not(.disabled) {
            background-color: #c0392b;
        }

        .approve {
            background-color: #3498db;
            color: white;
        }

        .approve.disabled {
            background-color: #95a5a6;
            cursor: not-allowed;
        }

        .approve:hover:not(.disabled) {
            background-color: #2980b9;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Clearance Requests</h2>
        <div class="search-bar">
            <input type="text" id="search-input" placeholder="Search by Student Name...">
        </div>
        <div class="student-list" id="student-list">
            @foreach($maEntries as $ma)
            <div class="student-card" data-name="{{ strtolower($ma->Student_Name) }}">
                <!-- Student Info -->
                <div class="student-info">
                    <div class="student-avatar">
                        <div class="avatar-placeholder"></div>
                    </div>
                    <div class="student-details">
                        <h3>Name: {{ $ma->Student_Name }}</h3>
                        <p>Register Number: {{ $ma->Student_Reg_NO }}</p>
                    </div>
                </div>
                <div class="request-info">
                    <span class="request-id">Clearance ID: {{ $ma->Clearance_NO }}</span>
                    <span class="status {{ strtolower($ma->MA_approved) }}">
                        Status: {{ $ma->MA_approved }}
                    </span>
                    <div class="buttons">
                        <button class="decline" id="decline-btn-{{ $ma->Clearance_NO }}" data-id="{{ $ma->Clearance_NO }}">Decline</button>
                        <button class="approve" id="approve-btn-{{ $ma->Clearance_NO }}" data-id="{{ $ma->Clearance_NO }}">Approve</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search-input');
            const studentList = document.getElementById('student-list');
            const studentCards = studentList.getElementsByClassName('student-card');

            searchInput.addEventListener('input', function () {
                const filter = searchInput.value.toLowerCase();

                for (let i = 0; i < studentCards.length; i++) {
                    const card = studentCards[i];
                    const studentName = card.getAttribute('data-name');

                    if (studentName.includes(filter)) {
                        card.style.display = "";
                    } else {
                        card.style.display = "none";
                    }
                }
            });

            @foreach($maEntries as $ma)
            (function () {
                const approveBtn = document.getElementById('approve-btn-{{ $ma->Clearance_NO }}');
                const declineBtn = document.getElementById('decline-btn-{{ $ma->Clearance_NO }}');

                // Set initial button states based on approval status
                function setButtonStates() {
                    if ("{{ $ma->MA_approved }}" === 'Approved') {
                        approveBtn.classList.add('disabled');
                        declineBtn.classList.add('disabled');
                        approveBtn.disabled = true;
                        declineBtn.disabled = true;
                    } else if ("{{ $ma->MA_approved }}" === 'Declined') {
                        approveBtn.classList.remove('disabled');
                        declineBtn.classList.add('disabled');
                        approveBtn.disabled = false;
                        declineBtn.disabled = true;
                    } else {
                        approveBtn.classList.remove('disabled');
                        declineBtn.classList.remove('disabled');
                        approveBtn.disabled = false;
                        declineBtn.disabled = false;
                    }
                }

                // Call the function to set initial states
                setButtonStates();

                // Handle approve button click
                approveBtn.addEventListener('click', function () {
                    if (approveBtn.disabled) return;

                    const clearanceId = approveBtn.getAttribute('data-id');
                    const confirmation = confirm('Are you sure you want to approve this clearance?');

                    if (confirmation) {
                        fetch('/approve-clearance', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ id: clearanceId })
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert('Clearance approved successfully!');
                                    location.reload(); // Reload the page to reflect changes
                                } else {
                                    alert('Failed to approve clearance.');
                                }
                            })
                            .catch(error => console.error('Error:', error));
                    }
                });

                // Handle decline button click
                declineBtn.addEventListener('click', function () {
                    if (declineBtn.disabled) return;

                    const clearanceId = declineBtn.getAttribute('data-id');
                    const confirmation = confirm('Are you sure you want to decline this clearance?');

                    if (confirmation) {
                        fetch('/decline-clearance', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ id: clearanceId })
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert('Clearance declined successfully!');
                                    location.reload(); // Reload the page to reflect changes
                                } else {
                                    alert('Failed to decline clearance.');
                                }
                            })
                            .catch(error => console.error('Error:', error));
                    }
                });
            })();
            @endforeach
        });
    </script>
</body>

</html>
