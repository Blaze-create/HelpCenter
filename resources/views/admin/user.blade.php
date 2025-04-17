@extends('layouts.dash')
@section('content')
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
                        <div class="item-id">
                            {{ $user->id }}
                        </div>
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
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#view">View</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


    <div class="modal fade" data-bs-backdrop="static" id="view" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" id="updateUser" method="post" action="">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        Viewing User detail
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="user-view">
                        <h6>User Detail</h6>
                        <div class="user-profile">
                            <div class="profile">
                                M
                            </div>
                            <div class="user-detail">
                                <div class="title">Full Name</div>
                                <div class="name" id="cn">Castel Charles Nicolas</div>
                                <div class="title">Email</div>
                                <div class="name" id="mail">charlescastel4@gmail.com</div>
                            </div>
                        </div>
                        <div class="user-job">
                            <div class="user-title">
                                <div class="title">Title</div>
                                <div class="name" id="title">IT Support Officer</div>
                            </div>
                            <div class="user-department">
                                <div class="title">Department</div>
                                <div class="name" id="department">IT Unit</div>
                            </div>
                        </div>
                        <h6>User Position</h6>
                        <div class="user-position">
                            <div class="mb-3">
                                <label for="    " class="form-label">Issue Type</label>
                                <select class="form-select" aria-label="Default select example">
                                    <option selected>Unassigned</option>
                                    @foreach ($issues as $issue)
                                        <option value="{{ $issue->type }}">{{ $issue->type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="    " class="form-label">User Role</label>
                                <select class="form-select" aria-label="Default select example">
                                    <option>Admins</option>
                                    <option value="1" selected>Technicians</option>
                                </select>
                            </div>
                        </div>
                        <h6>User tickets details</h6>
                        <div class="user-ticket">
                            <div class="ticket-active">
                                <div class="title">Tickets Active:</div>
                                <div class="name" id="active">10</div>
                            </div>
                            <div class="ticket-close">
                                <div class="title">Tickets resolved & Closed</div>
                                <div class="name" id="closed">100</div>
                            </div>
                        </div>
                    </div>




                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="closeBtn">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>



    <div class="modal fade" id="add_user" tabindex="-1">
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
                            @foreach ($issues as $issue)
                                <option value="{{ $issue->type }}">{{ $issue->type }}</option>
                            @endforeach
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

        document.addEventListener('DOMContentLoaded', () => {
            const btns = document.querySelectorAll('.item-action .btn.btn-primary');
            btns.forEach(btn => {
                btn.addEventListener('click', function() {
                    openModale(this);
                })
            })
        })

        const viewUserUrl = "{{ route('getUserData', ['id' => 'DUMMY_FILTER']) }}"
        const fetchUrl = viewUserUrl.replace('DUMMY_FILTER', '');


        function openModale(btn) {
            const row = btn.closest('.item-row.user');
            const id = row.querySelector('.item-id').textContent;
            const user = row.querySelector('.commonname').textContent;
            const department = row.querySelector('.department').textContent;
            const title = row.querySelector('.title').textContent;
            const itemType = row.querySelector('.item-type').textContent;
            const role = row.querySelector('.role').textContent;

            const form = document.getElementById('updateUser');
            const updateURL = "{{ route('updateUser', ['id' => 'PLACEHOLDER']) }}";
            form.action = updateURL.replace('PLACEHOLDER', formatText(id));

            document.getElementById('cn').innerHTML = formatText(user);
            document.getElementById('title').innerHTML = formatText(title);
            document.getElementById('department').innerHTML = formatText(department);
            document.getElementById('mail').innerHTML = '....';
            document.getElementById('active').innerHTML = '....';
            document.getElementById('closed').innerHTML = '....';

            const url = `${fetchUrl}${encodeURIComponent(id)}`;
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('active').innerHTML = data.active;
                    document.getElementById('closed').innerHTML = data.closed;
                    document.getElementById('mail').innerHTML = data.mail;
                })
                .catch(error => {
                    console.error('Error fetching ticket counts:', error);
                    document.getElementById('active').innerHTML = 'Error';
                    document.getElementById('closed').innerHTML = 'Error';
                });
        }

        function formatText(text) {
            text = text.trim();
            text = text.replace(/\s+/g, ' ');
            text = text.charAt(0) + text.slice(1);
            return text;
        }
    </script>
@endsection
