@extends('layouts.default')
@section('content')
    <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark" style="padding-right: 10px;padding-left: 10px  ;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">HelpCenter ICT</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#">Ticket</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">User management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Settings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Analyst</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="dashboard-title">
            <div class="title">
                <h1>User management</h1>
                <span>Showing {{ count($users) }} of {{ count($users) }} </span>
            </div>
            <div class="sidetab">
                <div class="menu">
                    <div data-bs-toggle="tooltip" data-bs-title="Add new user to management">
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal"
                            data-bs-target="#add_user"><i class="fa-solid fa-plus"></i> Add</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container item-table">
        <div class="item-wrapper">
            <div class="table-heading user">
                <div class="user">
                    Employee Details
                </div>
                <div class="task">
                    Current Task
                </div>
                <div class="Task-Assigned">
                    Task
                </div>
                <div class="role">
                    Role
                </div>
                <div class="action">
                    Action
                </div>
            </div>

            @foreach ($users as $user)
                @php
                    $commonname = '';
                    $titlee = '';
                    $department = '';

                    foreach ($user_cn as $ldap) {
                        if ($ldap['samaccountname'] == $user->samaccountname) {
                            $commonname = $ldap['cn'];
                            $titlee = $ldap['title'];
                            $department = $ldap['department'];
                            break;
                        }
                    }
                @endphp
                <div class="item-row user">
                    <div class="user-detail">
                        <div class="commonname">
                            {{ $commonname }}
                        </div>
                        <div class="department">
                            {{ $department }}
                        </div>
                        <div class="title">
                            {{ $titlee }}
                        </div>
                    </div>
                    <div class="number">
                        @foreach ($ticketCounts as $sam => $count)
                            @if ($sam == $user->samaccountname)
                                {{ $count }}
                            @endif
                        @endforeach
                    </div>
                    <div class="item-type">
                        {{ $user->type }}
                    </div>
                    @if ($user->role != 'Admins')
                        <div class="role">
                            <i class="fa-solid fa-wrench"></i>
                            {{ $user->role }}
                        </div>
                    @else
                        <div class="role admin">
                            <i class="fa-solid fa-crown"></i>
                            {{ $user->role }}
                        </div>
                    @endif
                    <div class="item-action">
                        <button type="button" class="btn btn-primary">View</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>






    <div class="modal fade" id="add_user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" id="addForm" action="{{ route('Add_User') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        Add a new User to Management
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="    " class="form-label">Search User by Full name or by username:</label>
                        <input class="form-control me-2" id="searchInput" type="search" placeholder="Search User"
                            aria-label="Search">
                    </div>
                    <div class="mb-3">
                        <label for="    " class="form-label">Identify and select the correct user:</label>
                        <ul class="get-user-ul" id="results">
                        </ul>
                    </div>
                    <input type="hidden" name="username" id="samaccount_post" required>
                    <div class="mb-3">
                        <label for="    " class="form-label">Please select the role the user will be assigned
                            to:</label>
                        <select class="form-select" aria-label="Default select example" name="role">
                            <option value="Admins">Admins</option>
                            <option value="Technicians" selected>Technicians</option>
                        </select>

                    </div>
                    <div class="mb-3">
                        <label for="    " class="form-label">Select preferred issue type for automatic task
                            assignment:</label>
                        <select class="form-select" aria-label="Default select example" name="type">
                            <option selected value="Network">Network</option>
                            <option value="Software">Software</option>
                            <option value="Hardware">Hardware</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="closeBtn">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary" id="add_user_submitBtn" disabled>Submit</button>
                </div>
            </form>
        </div>
    </div>


    <script>
        const searchInput = document.getElementById('searchInput');
        const resultsDiv = document.getElementById('results');
        const submitBtn = document.getElementById('add_user_submitBtn');
        const input_sam = document.getElementById('samaccount_post');

        const routeWithDummy = "{{ route('getUser', ['filter' => 'DUMMY_FILTER']) }}";
        const baseUrl = routeWithDummy.replace('DUMMY_FILTER', '');

        searchInput.addEventListener('input', function() {
            const filter = searchInput.value.trim();

            if (filter.length < 3) {
                resultsDiv.innerHTML = '';
                return;
            }
            const url = `${baseUrl}${encodeURIComponent(filter)}`;
            fetch(url)
                .then(response => {
                    if (!response.ok) throw new Error('Network response error');
                    return response.json();
                })
                .then(data => {
                    if (!data.length) {
                        resultsDiv.innerHTML = '<p>No users found</p>';
                        return;
                    }

                    let html = '';
                    data.forEach(user => {
                        html +=
                            `<li class="get-user-li" data-bs-sam="${user.samaccountname}">${user.samaccountname} - ${user.cn}</li>`;
                    });

                    resultsDiv.innerHTML = html;
                    selectUser();
                })
                .catch(err => {
                    console.error(err);
                    resultsDiv.innerHTML = '<p style="color:red;">Error fetching users</p>';
                });
        });

        function selectUser() {
            let selectedUserId = null;
            document.querySelectorAll('.get-user-li').forEach(item => {
                item.addEventListener('click', () => {
                    const isSelected = item.classList.contains('selected');

                    // Remove "selected" from all items
                    document.querySelectorAll('.get-user-li').forEach(li => li.classList.remove(
                        'selected'));

                    if (isSelected) {
                        // Deselect if already selected
                        selectedUserId = null;
                    } else {
                        // Select the clicked item
                        item.classList.add('selected');
                        selectedUserId = item.getAttribute('data-bs-sam');
                        input_sam.value = selectedUserId.toLowerCase();
                    }
                    submitBtn.disabled = !selectedUserId;
                });
            });
        }

        // document.getElementById('addForm').addEventListener('submit', function(event) {
        //     event.preventDefault(); // prevent actual form submission

        //     const formData = new FormData(this);

        //     // Convert to plain object (optional)
        //     const data = {};
        //     formData.forEach((value, key) => {
        //         data[key] = value;
        //     });

        //     console.log('Form Data:', data);
        // });
    </script>
@endsection
