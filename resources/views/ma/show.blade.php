<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MA Entries</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>MA Entry Details</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>Officer Name</th>
                    <th>Approved Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($maEntries as $ma)
                    <tr>
                        <td>{{ $ma->MA_off_name }}</td>
                        <td>{{ explode(' ', $ma->MA_approved)[0] }}</td>
                    </tr>
                    <tr>
                        <td>{{ $ma->HQvc_off_name }}</td>
                        <td>{{ explode(' ', $ma->HQ_approved)[0] }}</td>
                    </tr>
                    <tr>
                        <td>{{ $ma->Log_off_name }}</td>
                        <td>{{ explode(' ', $ma->Log_Off_approved)[0] }}</td>
                    </tr>
                    <tr>
                        <td>{{ $ma->DS_off_name }}</td>
                        <td>{{ explode(' ', $ma->DS_off_approved)[0] }}</td>
                    </tr>
                    <tr>
                        <td>{{ $ma->CM_off_name }}</td>
                        <td>{{ explode(' ', $ma->CM_off_approved)[0] }}</td>
                    </tr>
                    <tr>
                        <td>{{ $ma->Press_off_name }}</td>
                        <td>{{ explode(' ', $ma->Press_off_approved)[0] }}</td>
                    </tr>
                    <tr>
                        <td>{{ $ma->Store_off_name }}</td>
                        <td>{{ explode(' ', $ma->Store_off_approved)[0] }}</td>
                    </tr>
                    <tr>
                        <td>{{ $ma->PD_off_name }}</td>
                        <td>{{ explode(' ', $ma->PD_off_approved)[0] }}</td>
                    </tr>
                    <tr>
                        <td>{{ $ma->OCUS_Name }}</td>
                        <td>{{ explode(' ', $ma->OCUS_approved)[0] }}</td>
                    </tr>
                    <tr>
                        <td>{{ $ma->HQ_off_name }}</td>
                        <td>{{ explode(' ', $ma->HQ_off_approved)[0] }}</td>
                    </tr>
                    <tr>
                        <td>{{ $ma->it_OFF_name }}</td>
                        <td>{{ explode(' ', $ma->IT_off_approved)[0] }}</td>
                    </tr>
                    <tr>
                        <td>{{ $ma->Librarian_Name }}</td>
                        <td>{{ explode(' ', $ma->Librarian_approved)[0] }}</td>
                    </tr>
                    <tr>
                        <td>{{ $ma->Enlist_Name }}</td>
                        <td>{{ explode(' ', $ma->Enlist_approved)[0] }}</td>
                    </tr>
                    <tr>
                        <td>{{ $ma->ass_sec_off_name }}</td>
                        <td>{{ explode(' ', $ma->ACC_off_approved)[0] }}</td>
                    </tr>
                    <tr>
                        <td>{{ $ma->SODS_off_name }}</td>
                        <td>{{ explode(' ', $ma->SODS_off_approved)[0] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            @if($maEntries->first()->MA_approved === 'Approved')
                <button class="btn btn-success" disabled>Approved</button>
            @else
                <form action="{{ route('ma.approve', ['id' => $maEntries->first()->id]) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Approve</button>
                </form>
            @endif
        </div>
    </div>
</body>
</html>
