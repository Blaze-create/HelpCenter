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
                        <a class="nav-link active" aria-current="page" href="#">Ticket</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">User management</a>
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

    <div class="container-fluid">
        <div class="dashboard-title">
            <div class="title">
                <h1>Ongoing Tickets</h1>
                <span>Showing 10 of 50 </span>
            </div>
            <div class="sidetab">
                <div class="search">
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
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

            @foreach ($ongoing_tickets as $ticket)
                @php
                    $commonname = '';
                    $title = '';
                    $department = '';
                    foreach ($user_cn as $user) {
                        if ($user['samaccountname'] == $ticket->samaccountname) {
                            $commonname = $user['cn'];
                            $titlee = $user['title'];
                            $department = $user['department'];
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
                    <div class="item-assignment">
                        {{ $ticket->assigned_to }}
                    </div>
                    <div class="priority">
                        <span class="low"></span>
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
            <form class="modal-content" id="addForm">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        Taking Action on ticket
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-ticket">
                        <div class="user-info">
                            <div class="employee-detail">
                                <label for="" class="form-label">Employee Details</label>
                                <div class="commonname">
                                    Castel Charles Nicolas
                                </div>
                                <div class="department">
                                    IT Unit
                                </div>
                                <div class="title">
                                    Support Officer
                                </div>
                            </div>
                            <div class="issue-descrip">
                                <label for="" class="form-label">Issue Title</label>
                                <div class="title">
                                    Issue with Network Connection
                                </div>
                                <label for="" class="form-label">Issue Description</label>
                                <div class="description">
                                    The computer crashes randomly during usage. When the crash occurs,
                                    the screen goes black, and the system completely freezes. I am unable to use the
                                    mouse or keyboard, and the computer doesn't respond to any input. I have to hold
                                    down the power button for 10 seconds to force a shutdown and then restart the
                                    computer. Upon restarting,
                                </div>
                            </div>
                            <div class="issue-attachment">
                                No Attachment
                            </div>
                        </div>
                        <div class="action">
                            <div class="mb-3">
                                <label for="    " class="form-label">Issue Type</label>
                                <select class="form-select" aria-label="Default select example">
                                    <option selected>Unassigned</option>
                                    <option>Network</option>
                                    <option value="1">Hardware</option>
                                    <option value="2">Software</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="    " class="form-label">Priority</label>
                                <select class="form-select" aria-label="Default select example">
                                    <option selected>Low</option>
                                    <option value="1">Medium</option>
                                    <option value="2">High</option>
                                    <option value="2">Critical</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="    " class="form-label">Assign to</label>
                                <select class="form-select" aria-label="Default select example">
                                    <option selected>Unassigned</option>
                                    <option>Castel Charles Nicolas</option>
                                    <option value="1">John Doe</option>
                                    <option value="2">Ligma ball</option>
                                    <option value="2">Sarah How</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="    " class="form-label">Status</label>
                                <select class="form-select" aria-label="Default select example">
                                    <option selected>Open</option>
                                    <option value="1">In Progress</option>
                                    <option value="2">Closed</option>
                                </select>
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
            const date = row.querySelector('.date').textContent;
            const user = row.querySelector('.commonname').textContent;
            const department = row.querySelector('.department').textContent;
            const title = row.querySelector('.title').textContent;
            const itemType = row.querySelector('.item-type').textContent;
            const issueTitle = row.querySelector('.item-title').textContent;
            const assignment = row.querySelector('.item-assignment').textContent;
            const priority = row.querySelector('.priority').textContent;
            const status = row.querySelector('.item-status').textContent;

            console.log(formatText(user));
            console.log(formatText(issueTitle));

            function formatText(text) {
                text = text.trim();
                text = text.replace(/\s+/g, ' ');
                text = text.charAt(0).toUpperCase() + text.slice(1);
                return text;
            }
        }
    </script>
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
@endsection
