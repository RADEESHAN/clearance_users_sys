<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clearance Management System - KDU</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 240px;
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .sidebar .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar .logo img {
            width: 100px;
            margin-bottom: 10px;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .sidebar li {
            padding: 15px 10px;
            font-size: 18px;
            cursor: pointer;
            position: relative;
            border-radius: 5px;
            margin-bottom: 10px;
            transition: background-color 0.3s;
        }

        .sidebar li.active,
        .sidebar li:hover {
            background-color: #34495e;
        }

        .sidebar .badge {
            background-color: #e74c3c;
            border-radius: 50%;
            padding: 5px 10px;
            font-size: 14px;
            position: absolute;
            right: 10px;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
            background-color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .header-bar {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 10px;
            background-color: #5dade2;
            border-radius: 0 0 5px 5px;
        }

        .header-bar .circle {
            width: 20px;
            height: 20px;
            background-color: #dcdcdc;
            border-radius: 50%;
            margin-left: 10px;
        }

        .header-bar .circle.large {
            width: 30px;
            height: 30px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 2px solid #dcdcdc;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .clearance-id {
            font-size: 20px;
            color: #e67e22;
        }

        .profile-info {
            display: flex;
            align-items: center;
            margin: 20px 0;
        }

        .profile-picture {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: #dcdcdc;
            margin-right: 20px;
        }

        .profile-details p {
            margin: 0;
            line-height: 1.5;
        }

        .name {
            font-weight: bold;
            color: #3498db;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #dcdcdc;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
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

        .pagination-controls {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination-button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            background-color: #3498db;
            color: white;
            margin: 0 5px;
        }

        .pagination-button.disabled {
            background-color: #95a5a6;
            cursor: not-allowed;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="sidebar">
            <div class="logo">
                <img src="your-logo.png" alt="KDU Logo">
                <h2>Clearance Management System - KDU</h2>
            </div>
            <ul>
                <li class="active">Requests <span class="badge">{{ $maEntries->count() }}</span></li>
                <li>Account</li>
            </ul>
        </div>
        <div class="content">
            <div class="header-bar">
                <div class="circle"></div>
                <div class="circle large"></div>
            </div>
            <div class="header">
                <h1>Clearance Information</h1>
                <span class="clearance-id" id="clearance-id"></span>
            </div>
            <div class="profile-info">
                <div class="profile-picture"></div>
                <div class="profile-details" id="profile-details">
                    <!-- Profile details will be dynamically inserted here -->
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Section</th>
                        <th>Name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="records-table">
                    <!-- Records will be dynamically inserted here -->
                </tbody>
            </table>
            <div class="buttons">
                <!-- Approval and decline buttons -->
                <button class="decline" id="decline-btn" data-id="">Decline</button>
                <button class="approve" id="approve-btn" data-id="">Approve</button>
            </div>
            <div class="pagination-controls">
                <button class="pagination-button" id="prev-btn">Previous</button>
                <button class="pagination-button" id="next-btn">Next</button>
            </div>
        </div>
    </div>

    <script>
    // CSRF token for AJAX requests
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Example records data
    const records = @json($maEntries);
    let currentIndex = 0;

    function showRecord(index) {
        if (index < 0 || index >= records.length) return;

        const ma = records[index];

        document.getElementById('clearance-id').textContent = ma.Clearance_NO;

        document.getElementById('profile-details').innerHTML = `
            <p class="name">Name: ${ma.Student_Name}</p>
            <p>Reg No: ${ma.Student_Reg_NO}</p>
            <p>Day Scholar</p>
        `;

        document.getElementById('records-table').innerHTML = `
            <tr><td>Management Assistant</td><td>${ma.MA_off_name || 'N/A'}</td><td>${ma.MA_approved ? ma.MA_approved.split(' ')[0] : 'N/A'}</td></tr>
            <tr><td>Head Quarters</td><td>${ma.HQ_off_name || 'N/A'}</td><td>${ma.HQ_approved ? ma.HQ_approved.split(' ')[0] : 'N/A'}</td></tr>
            <tr><td>Staff Officer II Defence & Strategic</td><td>${ma.DS_off_name || 'N/A'}</td><td>${ma.DS_off_approved ? ma.DS_off_approved.split(' ')[0] : 'N/A'}</td></tr>
            <tr><td>Officer Commanding University Services</td><td>${ma.OCUS_Name || 'N/A'}</td><td>${ma.OCUS_approved ? ma.OCUS_approved.split(' ')[0] : 'N/A'}</td></tr>
            <tr><td>Log Officer</td><td>${ma.Log_off_name || 'N/A'}</td><td>${ma.Log_Off_approved ? ma.Log_Off_approved.split(' ')[0] : 'N/A'}</td></tr>
            <tr><td>Staff Officer II Faculty Of Post Graduate Studies</td><td>${ma.Faculty_of_Post_Graduate_Studies_Name || 'N/A'}</td><td>${ma.Faculty_of_Post_Graduate_Studies_Status || 'N/A'}</td></tr>
            <tr><td>Account Section</td><td>${ma.Account_Section_Name || 'N/A'}</td><td>${ma.Account_Section_Status || 'N/A'}</td></tr>
            <tr><td>Library</td><td>${ma.Librarian_Name || 'N/A'}</td><td>${ma.Librarian_approved ? ma.Librarian_approved.split(' ')[0] : 'N/A'}</td></tr>
            <tr><td>Enlistment</td><td>${ma.Enlist_Name || 'N/A'}</td><td>${ma.Enlist_approved ? ma.Enlist_approved.split(' ')[0] : 'N/A'}</td></tr>
            <tr><td>Vice Chancellor</td><td>${ma.HQvc_off_name || 'N/A'}</td><td>${ma.HQ_approved ? ma.HQ_approved.split(' ')[0] : 'N/A'}</td></tr>
        `;

        document.getElementById('approve-btn').dataset.id = ma.Clearance_NO;
        document.getElementById('decline-btn').dataset.id = ma.Clearance_NO;

        // Update button states
        const approveBtn = document.getElementById('approve-btn');
        const declineBtn = document.getElementById('decline-btn');

        if (ma.MA_approved === 'Approved') {
            approveBtn.classList.add('disabled');
            declineBtn.classList.add('disabled');
            approveBtn.disabled = true;
            declineBtn.disabled = true;
        } else if (ma.MA_approved === 'Declined') {
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

        document.getElementById('prev-btn').disabled = index === 0;
        document.getElementById('next-btn').disabled = index === records.length - 1;
    }

    document.getElementById('prev-btn').addEventListener('click', function() {
        if (currentIndex > 0) {
            currentIndex--;
            showRecord(currentIndex);
        }
    });

    document.getElementById('next-btn').addEventListener('click', function() {
        if (currentIndex < records.length - 1) {
            currentIndex++;
            showRecord(currentIndex);
        }
    });

    // Show the first record on page load
    showRecord(currentIndex);

    // AJAX functionality for approval and decline
    document.getElementById('approve-btn').addEventListener('click', function() {
        if (this.classList.contains('disabled')) return;

        const clearanceId = this.getAttribute('data-id');
        const confirmation = confirm('Are you sure you want to approve this clearance?');

        if (confirmation) {
            fetch('/approve-clearance', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ id: clearanceId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Clearance approved successfully!');
                    location.reload();
                } else {
                    alert('Failed to approve clearance.');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });

    document.getElementById('decline-btn').addEventListener('click', function() {
        if (this.classList.contains('disabled')) return;

        const clearanceId = this.getAttribute('data-id');
        const confirmation = confirm('Are you sure you want to decline this clearance?');

        if (confirmation) {
            fetch('/decline-clearance', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ id: clearanceId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Clearance declined successfully!');
                    location.reload();
                } else {
                    alert('Failed to decline clearance.');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });
    </script>
</body>

</html>
