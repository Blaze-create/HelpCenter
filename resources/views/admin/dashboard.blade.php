@extends('layouts.dash')
@section('content')
    <div class="container-fluid">
        <div class="dashboard-title">
            <div class="title">
                <h1>Ongoing Tickets</h1>
                <span>Showing {{ count($ongoing_tickets) }} of {{ count($ongoing_tickets) }} </span>
            </div>

            <form class="sidetab"method="GET" action="{{ route('dashboard') }}" id="filterForm">
                <select class="form-select" aria-label="Default select example" style="width:200px;" name="filter"
                    onchange="this.form.submit()">
                    <option value="">-- Sort By --</option>
                    <option value="date_desc" {{ request('filter') == 'date_desc' ? 'selected' : '' }}>Newest First</option>
                    <option value="date_asc" {{ request('filter') == 'date_asc' ? 'selected' : '' }}>Oldest First</option>
                    <option value="priority" {{ request('filter') == 'priority' ? 'selected' : '' }}>Priority</option>
                </select>
                <div class="search">
                    <div class="d-flex" role="search">
                        <input class="form-control me-2" type="search" name="search" placeholder="Search tickets..."
                            value="{{ request('search') }}">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <div class="container-fluid item-table">
        <div class="item-wrapper">
            <div class="table-heading">
                <div class="date">Date</div>
                <div class="user">Employee Details</div>
                <div class="type">Type</div>
                <div class="issue">Issue</div>
                <div class="assign">Assign to</div>
                <div class="priority">Priority</div>
                <div class="status">Status</div>
                <div class="action">Action</div>
            </div>

            @foreach ($ongoing_tickets as $ticket)
                @php
                    $commonname = '';

                    $titlee = '';
                    $department = '';
                    $assigned_to = 'unassigned';
                    foreach ($user_cn as $user) {
                        if ($user['samaccountname'] == $ticket->samaccountname) {
                            $commonname = $user['cn'];
                            $titlee = $user['title'];
                            $department = $user['department'];
                            break;
                        }
                    }
                    foreach ($techDetail as $user) {
                        if ($user['samaccountname'] == $ticket->assigned_to) {
                            $assigned_to = $user['cn'];
                            break;
                        }
                    }
                    $status = '';
                    if ($ticket->status == 'open') {
                        $status = 'open';
                    } elseif ($ticket->status == 'in_progress') {
                        $status = 'inprogress';
                    } else {
                        $status = 'closed';
                    }
                @endphp
                <div class="item-row">
                    <div class="item-id">
                        {{ $ticket->id }}
                    </div>
                    <div class="date">
                        {{ \Carbon\Carbon::parse($ticket->created_at)->diffForHumans() }}
                    </div>
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
                    <div class="item-type">
                        {{ $ticket->category }}
                    </div>
                    <div class="item-title">
                        {{ $ticket->title }}
                    </div>
                    <div class="item-description">
                        {{ $ticket->description }}
                    </div>
                    <div class="item-assignment">
                        {{ $assigned_to }}
                    </div>
                    <div class="priority">
                        <span
                            class="{{ $ticket->priority === 'unassigned' ? 'low' : strtolower($ticket->priority) }}"></span>
                    </div>
                    <div class="item-status">
                        <span class="{{ $status }}"></span>
                    </div>
                    <div class="item-action">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#view">View</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>




    <div class="container-fluid">
        <div class="dashboard-title">
            <div class="title">
                <h1>Recently Resolved Tickets</h1>
                <span>20 resolved this Months</span>
            </div>
        </div>
    </div>
    <div class="container-fluid item-table">
        <div class="item-wrapper">
            <div class="table-heading">
                <div class="date">Date</div>
                <div class="user">Employee Details</div>
                <div class="type">Type</div>
                <div class="issue">Issue</div>
                <div class="assign">Assign to</div>
                <div class="priority">Priority</div>
                <div class="status">Status</div>
                <div class="action">Action</div>
            </div>
            <div class="item-row">
                <div class="date">
                    1 Days ago
                </div>
                <div class="user-detail">
                    <div class="commonname">
                        Castel Charles Nicolas
                    </div>
                    <div class="department">
                        IT Unit
                    </div>
                    <div class="title">
                        IT Support Officer
                    </div>
                </div>
                <div class="item-type">
                    Hardware
                </div>
                <div class="item-title">
                    Issue with Network connection
                </div>
                <div class="item-assignment">
                    unassigned
                </div>
                <div class="priority">
                    <span class="low"></span>
                </div>
                <div class="item-status">
                    <span class="open"></span>
                </div>
                <div class="item-action">
                    <button type="button" class="btn btn-primary">View</button>
                </div>
            </div>

            <!-- Second Row -->
            <div class="item-row">
                <div class="date">
                    1 Week ago
                </div>
                <div class="user-detail">
                    <div class="commonname">
                        Sarah Jane Doe
                    </div>
                    <div class="department">
                        HR Unit
                    </div>
                    <div class="title">
                        HR Manager
                    </div>
                </div>
                <div class="item-type">
                    Software
                </div>
                <div class="item-title">
                    Missing Employee Records
                </div>
                <div class="item-assignment">
                    Batipse Luc Goelson
                </div>
                <div class="priority">
                    <span class="medium"></span>
                </div>
                <div class="item-status">
                    <span class="closed"></span>
                </div>
                <div class="item-action">
                    <button type="button" class="btn btn-primary">View</button>
                </div>
            </div>

            <!-- Third Row -->
            <div class="item-row">
                <div class="date">
                    1 Year ago
                </div>
                <div class="user-detail">
                    <div class="commonname">
                        John Smith
                    </div>
                    <div class="department">
                        Marketing Unit
                    </div>
                    <div class="title">
                        Marketing Specialist
                    </div>
                </div>
                <div class="item-type">
                    Network
                </div>
                <div class="item-title">
                    Website Display Error
                </div>
                <div class="item-assignment">
                    unassigned
                </div>
                <div class="priority">
                    <span class="high"></span>
                </div>
                <div class="item-status">
                    <span class="inprogress"></span>
                </div>
                <div class="item-action">
                    <button type="button" class="btn btn-primary">View</button>
                </div>
            </div>

            <!-- Fourth Row -->
            <div class="item-row">
                <div class="date">
                    5 Days ago
                </div>
                <div class="user-detail">
                    <div class="commonname">
                        Emily R. Davis
                    </div>
                    <div class="department">
                        Finance Unit
                    </div>
                    <div class="title">
                        Financial Analyst
                    </div>
                </div>
                <div class="item-type">
                    Hardware
                </div>
                <div class="item-title">
                    Unable to Access Reports
                </div>
                <div class="item-assignment">
                    unassigned
                </div>
                <div class="priority">
                    <span class="critical"></span>
                </div>
                <div class="item-status">
                    <span class="open"></span>
                </div>
                <div class="item-action">
                    <button type="button" class="btn btn-primary">View</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" data-bs-backdrop="static" id="view" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <form class="modal-content" id="updateForm" method="post" action="">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        Taking Action on ticket
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-ticket">
                        <div class="user-info">
                            <div class="top-bar">
                                <div class="ticketid">
                                    <div class="id">
                                        <label for="" class="form-label">Ticket Number:</label> <span
                                            id="ticket_id">0001</span>
                                    </div>
                                    <div class="date">
                                        <label for="" class="form-label">Date:</label> <span id="ticket_date">1
                                            Day ago</span>
                                    </div>
                                </div>
                                <div class="employee-detail">
                                    <label for="" class="form-label">Employee Details</label>
                                    <div class="commonname" id="cn">
                                        Castel Charles Nicolas
                                    </div>
                                    <div class="department" id="department">
                                        IT Unit
                                    </div>
                                    <div class="title" id="title">
                                        Support Officer
                                    </div>
                                </div>
                                <div class="issue-attachment">
                                    No Attachment
                                </div>
                            </div>
                            <div class="issue-descrip">
                                <label for="" class="form-label">Issue Title</label>
                                <div class="title" id="issue_title">
                                    Issue with Network Connection
                                </div>
                                <label for="" class="form-label">Issue Description</label>
                                <div class="description" id="description">
                                </div>
                            </div>
                            <div class="action">
                                <div class="mb-3">
                                    <label for="    " class="form-label">Issue Type</label>
                                    <select class="form-select" aria-label="Default select example" name="category">
                                        <option selected>Unassigned</option>
                                        @foreach ($issueTypes as $issueType)
                                            <option value="{{ $issueType->type }}">{{ $issueType->type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="    " class="form-label">Priority</label>
                                    <select class="form-select" aria-label="Default select example"
                                        id="form_select_priority"@if (!$userRole) disabled @endif
                                        name="priority">
                                        <option selected value="low">Low</option>
                                        <option value="medium">Medium</option>
                                        <option value="high">High</option>
                                        <option value="critical">Critical</option>
                                    </select>
                                </div>

                                {{-- TODO: change technicians ldap to technician sql  --}}
                                <div class="mb-3">
                                    <label for="    " class="form-label">Assign to</label>
                                    <select class="form-select" aria-label="Default select example" id="form_select_tech"
                                        @if (!$userRole) disabled @endif name="assigned_to">
                                        <option selected>Unassigned</option>
                                        @foreach ($techDetail as $technician)
                                            <option value="{{ $technician['samaccountname'] }}">{{ $technician['cn'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="    " class="form-label">Status</label>
                                    <select class="form-select" aria-label="Default select example"
                                        id="form_select_status" name="status">
                                        <option selected value="open">Open</option>
                                        <option value="in_progress">In Progress</option>
                                        <option value="closed">Closed</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="comment">
                            <div class="comment-section">
                                <div class="a-comment">
                                    <div class="profile">
                                    </div>
                                    <div class="commentt">
                                        <div class="name">
                                            Castel Charles Nicolas
                                        </div>
                                        <div class="the-comment">
                                            Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                                        </div>
                                    </div>
                                </div>
                                <div class="a-comment">
                                    <div class="profile">
                                    </div>
                                    <div class="commentt">
                                        <div class="name">
                                            Castel Charles Nicolas
                                        </div>
                                        <div class="the-comment">
                                            Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="comment-input">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Comments or Notes"
                                        aria-label="Recipient's username" aria-describedby="button-addon2">
                                    <button class="btn btn-primary  " type="button" id="button-addon2">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" data-bs-toggle="tooltip"
                        data-bs-title="Save changes">Save</button>
                    @if (!$userRole)
                        <button type="button" class="btn btn-success" data-bs-toggle="tooltip"
                            data-bs-title="Closed the ticket as Resolved" id="resolve">
                            Resolve
                        </button>
                        <button type="button" class="btn btn-success" data-bs-toggle="tooltip"
                            data-bs-title="Accept the ticket and change its status to 'in progress'" id="accept">
                            Accept
                        </button>
                        <button type="button" class="btn btn-danger"
                            data-bs-toggle="tooltip"data-bs-title='Escalate ticket to higher support unit'>Escalate</button>
                    @endif
                </div>
            </form>
        </div>
    </div>














    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const btns = document.querySelectorAll('.item-action .btn.btn-primary');

            btns.forEach(btn => {
                btn.addEventListener('click', function() {
                    openModali(this)
                })
            })
        })

        function openModali(btn) {
            const row = btn.closest('.item-row');
            const id = row.querySelector('.item-id').textContent
            const date = row.querySelector('.date').textContent;
            const user = row.querySelector('.commonname').textContent;
            const department = row.querySelector('.department').textContent;
            const title = row.querySelector('.title').textContent;
            const description = row.querySelector('.item-description').textContent;
            const itemType = row.querySelector('.item-type').textContent;
            const issueTitle = row.querySelector('.item-title').textContent;
            const assignment = row.querySelector('.item-assignment').textContent;
            const priority = row.querySelector('.priority span')?.className;
            const status = row.querySelector('.item-status span')?.className;
            const select_status = document.getElementById('form_select_status');
            const select_priority = document.getElementById('form_select_priority');
            const select_tech = document.getElementById('form_select_tech');
            const form = document.getElementById('updateForm');

            const resolve = document.getElementById('resolve');
            const accept = document.getElementById('accept');

            if (formatText(status) == 'open') {
                resolve.style.display = 'none';
                accept.style.display = 'block';
            } else {
                accept.style.display = 'none';
                resolve.style.display = 'block';
            }

            document.getElementById('ticket_id').innerHTML = formatText(id).padStart(6, '0');
            document.getElementById('cn').innerHTML = formatText(user);
            document.getElementById('department').innerHTML = formatText(department);
            document.getElementById('title').innerHTML = formatText(title);
            document.getElementById('issue_title').innerHTML = formatText(issueTitle);
            document.getElementById('description').innerHTML = formatText(description);
            document.getElementById('ticket_date').innerHTML = formatText(date);

            const updateURL = "{{ route('updateTicket', ['id' => 'PLACEHOLDER']) }}";
            form.action = updateURL.replace('PLACEHOLDER', formatText(id));

            if (status && select_status) {
                let valueToSelect = "";

                switch (status.toLowerCase()) {
                    case "open":
                        valueToSelect = "Open";
                        break;
                    case "inprogress":
                        valueToSelect = "In Progress";
                        break;
                    case "closed":
                        valueToSelect = "Closed";
                        break;
                }
                for (let option of select_status.options) {
                    if (option.text.trim() === valueToSelect) {
                        option.selected = true;
                        break;
                    }
                }
            }

            let found = false;
            for (let option of select_tech.options) {
                if (option.text.trim().toLowerCase() === formatText(assignment).toLowerCase()) {
                    option.selected = true;
                    found = true;
                    break;
                }
            }
            if (!found) {
                for (let option of select_tech.options) {
                    if (option.text.trim().toLowerCase() === 'unassigned') {
                        option.selected = true;
                        break;
                    }
                }
            }

            if (priority && select_priority) {
                let valueToSelect = "";

                switch (priority.toLowerCase()) {
                    case "low":
                        valueToSelect = "Low";
                        break;
                    case "medium":
                        valueToSelect = "Medium";
                        break;
                    case "high":
                        valueToSelect = "High";
                        break;
                    case "critical":
                        valueToSelect = "Critical";
                        break;
                }
                for (let option of select_priority.options) {
                    if (option.text.trim() === valueToSelect) {
                        option.selected = true;
                        break;
                    }
                }

            }

            function formatText(text) {
                text = text.trim();
                text = text.replace(/\s+/g, ' ');
                text = text.charAt(0) + text.slice(1);
                return text;
            }
        }
    </script>
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
@endsection
