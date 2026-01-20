<x-metrolar-layout>
    <x-slot name="title">To Do List</x-slot>
    <x-slot name="subheader">
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">To Do List</h5>
                </div>
                <div class="d-flex align-items-center">
                    <button type="button" class="btn btn-primary font-weight-bold" data-toggle="modal"
                        data-target="#kt_modal_todo" id="btn_open_create_modal">
                        <i class="flaticon2-plus-1"></i> Add Task
                    </button>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="row">
        <!-- Todo List Column -->
        <div class="col-lg-8">
            <div class="card card-custom gutter-b">
                <div class="card-header border-0 py-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label font-weight-bolder text-dark">My Tasks</span>
                        <span class="text-muted mt-3 font-weight-bold font-size-sm">Manage your daily tasks</span>
                    </h3>
                </div>
                <div class="card-body py-0">
                    <div class="table-responsive">
                        <table class="table table-head-custom table-vertical-center" id="kt_todo_table">
                            <thead>
                                <tr class="text-left">
                                    <th class="pl-0" style="width: 30px">Status</th>
                                    <th style="min-width: 150px">Task</th>
                                    <th style="min-width: 120px">Due Date</th>
                                    <th class="text-right pr-0" style="min-width: 130px">Action</th>
                                </tr>
                            </thead>
                            <tbody id="todo_list_container">
                                <!-- Loaded via JS -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notepad Column -->
        <div class="col-lg-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="card-title font-weight-bolder text-dark mb-0">My Notes</h3>
                <button type="button" class="btn btn-sm btn-primary font-weight-bold" onclick="NotepadApp.addNote()">
                    <i class="flaticon2-plus"></i> Add Note
                </button>
            </div>

            <div id="notepad_container">
                <!-- Notes will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Modal-->
    <div class="modal fade" id="kt_modal_todo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="kt_form_todo">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Task Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="todo_id" name="id">
                        <div class="form-group">
                            <label>Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="title" id="todo_title"
                                placeholder="Enter task title" required />
                        </div>
                        <div class="form-group">
                            <label>Due Date</label>
                            <input type="date" class="form-control" name="due_date" id="todo_due_date" />
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" name="description" id="todo_description" rows="3"></textarea>
                        </div>
                        <div class="form-group form-check" id="check_completed_container" style="display:none;">
                            <input type="checkbox" class="form-check-input" id="todo_is_completed" name="is_completed">
                            <label class="form-check-label" for="todo_is_completed">Completed</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold"
                            data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary font-weight-bold" id="btn_save_todo">Save
                            changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            "use strict";

            // Headers for Fetch
            const headers = {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            };

            const TodoApp = function() {
                const _loadTodos = () => {
                    KTApp.block('#kt_todo_table', {
                        overlayColor: '#000000',
                        state: 'primary',
                        message: 'Processing...'
                    });

                    fetch("{{ route('todos.list') }}", {
                            method: 'GET',
                            headers: headers
                        })
                        .then(response => response.json())
                        .then(res => {
                            KTApp.unblock('#kt_todo_table');
                            if (res.success) {
                                _renderTable(res.data);
                            }
                        })
                        .catch(err => {
                            KTApp.unblock('#kt_todo_table');
                            console.error(err);
                            toastr.error("Failed to load todos");
                        });
                };

                const _renderTable = (data) => {
                    const container = document.getElementById('todo_list_container');
                    container.innerHTML = '';

                    if (data.length === 0) {
                        container.innerHTML =
                            '<tr><td colspan="4" class="text-center text-muted">No tasks found</td></tr>';
                        return;
                    }

                    data.forEach(todo => {
                        const isChecked = todo.is_completed ? 'checked' : '';
                        const textDecor = todo.is_completed ? 'text-decoration: line-through;' : '';

                        // Action buttons
                        const editBtn = `
                            <a href="javascript:;" class="btn btn-icon btn-light btn-hover-primary btn-sm mx-1"
                                onclick="TodoApp.editItem(${todo.id}, '${todo.title}', '${todo.description || ''}', '${todo.due_date || ''}', ${todo.is_completed})" title="Edit">
                                <span class="svg-icon svg-icon-md svg-icon-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"/>
                                            <path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114732 12.1704054,4.68743216 12.4682693,4.42533086 L14.730303,2.44685117 C15.4219352,1.83407987 16.5165842,1.83856417 17.2036662,2.45780515 C17.8907482,3.07823547 17.8924618,4.17045763 17.2084799,4.78657662 L15.7082305,6.09633807 L15.932849,18.8703358 C15.9084323,19.9238804 15.0110364,20.7308967 14.1206132,20.7634358 L12.8256565,20.8123019 C12.4332219,20.6698964 12.193297,20.3705096 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.749023) rotate(-135.000000) translate(-14.701953, -10.749023) "/>
                                            <path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                        </g>
                                    </svg>
                                </span>
                            </a>
                        `;
                        const delBtn = `
                            <a href="javascript:;" class="btn btn-icon btn-light btn-hover-danger btn-sm"
                                onclick="TodoApp.deleteItem(${todo.id})" title="Delete">
                                <span class="svg-icon svg-icon-md svg-icon-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"/>
                                            <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"/>
                                            <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"/>
                                        </g>
                                    </svg>
                                </span>
                            </a>
                        `;

                        // New Complete/Undo Button
                        const toggleBtn = todo.is_completed ? `
                            <a href="javascript:;" class="btn btn-icon btn-light btn-hover-warning btn-sm mx-1"
                                onclick="TodoApp.toggleComplete(${todo.id}, false)" title="Mark as Incomplete">
                                <i class="flaticon2-refresh"></i>
                            </a>
                        ` : `
                            <a href="javascript:;" class="btn btn-icon btn-light btn-hover-success btn-sm mx-1"
                                onclick="TodoApp.toggleComplete(${todo.id}, true)" title="Mark as Completed">
                                <i class="flaticon2-check-mark"></i>
                            </a>
                        `;

                        const row = `
                            <tr class="${todo.is_completed ? 'bg-light-success' : ''}">
                                <td class="pl-0">
                                    <label class="checkbox checkbox-lg checkbox-inline">
                                        <input type="checkbox" value="1" ${isChecked} onchange="TodoApp.toggleComplete(${todo.id}, this.checked)">
                                        <span></span>
                                    </label>
                                </td>
                                <td>
                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg" style="${textDecor}">${todo.title}</span>
                                    <span class="text-muted font-weight-bold d-block">${todo.description || ''}</span>
                                </td>
                                <td>
                                    <span class="text-primary font-weight-bolder d-block font-size-lg">${todo.due_date ? new Date(todo.due_date).toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' }) : '-'}</span>
                                </td>
                                <td class="text-right pr-0">
                                    ${toggleBtn}
                                    ${editBtn}
                                    ${delBtn}
                                </td>
                            </tr>
                        `;
                        container.insertAdjacentHTML('beforeend', row);
                    });
                };

                const _handleSubmit = (e) => {
                    e.preventDefault();

                    const btn = document.getElementById('btn_save_todo');
                    const form = document.getElementById('kt_form_todo');
                    const todoId = document.getElementById('todo_id').value;
                    const isEdit = !!todoId;

                    // Build JSON payload
                    const formData = new FormData(form);
                    const data = Object.fromEntries(formData.entries());
                    // Checkbox handling for completion
                    data.is_completed = form.querySelector('#todo_is_completed').checked ? 1 : 0;

                    // Button loading state
                    KTUtil.btnWait(btn, "spinner spinner-right spinner-white pr-15", "Saving...");

                    const url = isEdit ?
                        "{{ route('todos.update', ':id') }}".replace(':id', todoId) :
                        "{{ route('todos.store') }}";

                    const method = isEdit ? 'PUT' : 'POST';

                    fetch(url, {
                            method: method,
                            headers: headers,
                            body: JSON.stringify(data)
                        })
                        .then(async response => {
                            const isJson = response.headers.get('content-type')?.includes('application/json');
                            const data = isJson ? await response.json() : null;

                            if (!response.ok) {
                                // Handle Validation Errors (422)
                                if (response.status === 422 && data && data.errors) {
                                    let errorMsg = '';
                                    Object.values(data.errors).forEach(err => {
                                        errorMsg += err.join('<br>') + '<br>';
                                    });
                                    toastr.error(errorMsg, "Validation Error");
                                }
                                // Handle other errors
                                else {
                                    const msg = (data && data.message) || response.statusText;
                                    toastr.error(msg, "Error " + response.status);
                                }
                                return {
                                    success: false
                                }; // Stop promise chain
                            }

                            return data;
                        })
                        .then(res => {
                            KTUtil.btnRelease(btn);
                            if (res && res.success) {
                                $('#kt_modal_todo').modal('hide');
                                toastr.success(res.message);
                                _loadTodos();
                            }
                        })
                        .catch(err => {
                            KTUtil.btnRelease(btn);
                            console.error(err);
                            toastr.error("An unexpected error occurred. Check console for details.");
                        });
                };

                return {
                    init: function() {
                        _loadTodos();
                        document.getElementById('kt_form_todo').addEventListener('submit', _handleSubmit);

                        $('#kt_modal_todo').on('hidden.bs.modal', function() {
                            document.getElementById('kt_form_todo').reset();
                            document.getElementById('todo_id').value = '';
                            document.getElementById('check_completed_container').style.display = 'none';
                        });

                        $('#btn_open_create_modal').on('click', function() {
                            document.getElementById('check_completed_container').style.display = 'none';
                        });

                        NotepadApp.init(); // Init notepad
                    },
                    // ... editItem, deleteItem ...
                    editItem: function(id, title, desc, dueDate, isCompleted) {
                        document.getElementById('todo_id').value = id;
                        document.getElementById('todo_title').value = title;
                        document.getElementById('todo_description').value = desc;
                        document.getElementById('todo_due_date').value = dueDate ? new Date(dueDate).toISOString()
                            .split('T')[0] : '';
                        document.getElementById('todo_is_completed').checked = isCompleted;
                        document.getElementById('check_completed_container').style.display = 'block';

                        $('#kt_modal_todo').modal('show');
                    },
                    deleteItem: function(id) {
                        Swal.fire({
                            title: "Are you sure?",
                            text: "You won't be able to revert this!",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonText: "Yes, delete it!"
                        }).then(function(result) {
                            if (result.value) {
                                fetch("{{ route('todos.destroy', ':id') }}".replace(':id', id), {
                                        method: 'DELETE',
                                        headers: headers
                                    })
                                    .then(res => res.json())
                                    .then(res => {
                                        if (res.success) {
                                            toastr.success(res.message);
                                            _loadTodos();
                                        }
                                    });
                            }
                        });
                    },
                    toggleComplete: function(id, isChecked) {
                        fetch("{{ route('todos.update', ':id') }}".replace(':id', id), {
                                method: 'PUT',
                                headers: headers,
                                body: JSON.stringify({
                                    is_completed: isChecked
                                })
                            })
                            .then(res => res.json())
                            .then(res => {
                                if (res.success) {
                                    toastr.success("Task updated");
                                    _loadTodos();
                                }
                            });
                    }
                };
            }();

            const NotepadApp = function() {
                const colors = ['white', 'warning', 'success', 'danger', 'info', 'primary'];
                const colorClasses = {
                    'white': 'card-custom', // default white
                    'warning': 'bg-light-warning',
                    'success': 'bg-light-success',
                    'danger': 'bg-light-danger',
                    'info': 'bg-light-info',
                    'primary': 'bg-light-primary'
                };

                let debounceTimers = {};

                const _loadNotes = () => {
                    KTApp.block('#notepad_container', {
                        overlayColor: '#000000',
                        state: 'primary',
                        message: 'Loading...'
                    });

                    fetch("{{ route('todos.scratchpad.index') }}", {
                            headers: headers
                        })
                        .then(res => res.json())
                        .then(res => {
                            KTApp.unblock('#notepad_container');
                            if (res.success) {
                                _renderNotes(res.data);
                            }
                        })
                        .catch(err => {
                            KTApp.unblock('#notepad_container');
                            console.error(err);
                        });
                };

                const _renderNotes = (notes) => {
                    const container = document.getElementById('notepad_container');
                    container.innerHTML = '';

                    if (notes.length === 0) {
                        container.innerHTML =
                            '<div class="text-center text-muted mt-5">No notes yet. Click "Add Note" to create one.</div>';
                        return;
                    }

                    notes.forEach((note, index) => {
                        const bgClass = colorClasses[note.color] || 'card-custom';
                        const isFirst = index === 0;
                        const isLast = index === notes.length - 1;

                        let colorOptions = '';
                        colors.forEach(c => {
                            colorOptions +=
                                `<a class="dropdown-item ${c === note.color ? 'active' : ''}" href="javascript:;" onclick="NotepadApp.updateColor(${note.id}, '${c}')"><span class="label label-dot label-${c} mr-2"></span> ${c.charAt(0).toUpperCase() + c.slice(1)}</a>`;
                        });

                        const html = `
                        <div class="card ${bgClass} gutter-b mb-4" id="note_${note.id}">
                            <div class="card-header border-0 min-h-50px px-4 pt-4">
                                <div class="card-title w-100 mr-2">
                                     <input type="text" class="form-control form-control-transparent h-auto p-0 font-weight-bolder text-dark"
                                        value="${note.title}" placeholder="Title..."
                                        onchange="NotepadApp.updateTitle(${note.id}, this.value)">
                                </div>
                                <div class="card-toolbar">
                                    <div class="dropdown dropdown-inline mr-2">
                                        <button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-md" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="flaticon2-gear"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            ${colorOptions}
                                        </div>
                                    </div>
                                    ${!isFirst ? `<button type="button" class="btn btn-clean btn-sm btn-icon" onclick="NotepadApp.moveNote(${note.id}, -1)"><i class="flaticon2-up"></i></button>` : ''}
                                    ${!isLast ? `<button type="button" class="btn btn-clean btn-sm btn-icon" onclick="NotepadApp.moveNote(${note.id}, 1)"><i class="flaticon2-down"></i></button>` : ''}
                                    <button type="button" class="btn btn-clean btn-sm btn-icon" onclick="NotepadApp.deleteNote(${note.id})"><i class="flaticon2-trash text-danger"></i></button>
                                </div>
                            </div>
                            <div class="card-body pt-0 px-4 pb-4">
                                <textarea class="form-control form-control-solid bg-transparent" rows="5"
                                    placeholder="Type note..." style="resize: none;"
                                    oninput="NotepadApp.updateContent(${note.id}, this.value)">${note.content || ''}</textarea>
                                <div class="text-right mt-1"><small class="text-muted" id="status_${note.id}"></small></div>
                            </div>
                        </div>
                       `;
                        container.insertAdjacentHTML('beforeend', html);
                    });
                };

                return {
                    init: function() {
                        _loadNotes();
                    },
                    addNote: function() {
                        fetch("{{ route('todos.scratchpad.store') }}", {
                                method: 'POST',
                                headers: headers,
                                body: JSON.stringify({
                                    title: 'Untitled Note',
                                    color: 'white'
                                })
                            })
                            .then(res => res.json())
                            .then(res => {
                                if (res.success) _loadNotes();
                            });
                    },
                    updateContent: function(id, content) {
                        document.getElementById(`status_${id}`).innerHTML = 'Saving...';
                        clearTimeout(debounceTimers[id]);
                        debounceTimers[id] = setTimeout(() => {
                            this.saveNote(id, {
                                content: content
                            });
                        }, 1000);
                    },
                    updateTitle: function(id, title) {
                        this.saveNote(id, {
                            title: title
                        });
                    },
                    updateColor: function(id, color) {
                        this.saveNote(id, {
                            color: color
                        }).then(() => _loadNotes());
                    },
                    saveNote: function(id, data) {
                        return fetch("{{ route('todos.scratchpad.update', ':id') }}".replace(':id', id), {
                                method: 'PUT',
                                headers: headers,
                                body: JSON.stringify(data)
                            })
                            .then(res => res.json())
                            .then(res => {
                                if (res.success) {
                                    const statusEl = document.getElementById(`status_${id}`);
                                    if (statusEl) statusEl.innerHTML = 'Saved';
                                }
                            });
                    },
                    deleteNote: function(id) {
                        Swal.fire({
                            title: "Delete Note?",
                            text: "This cannot be undone",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonText: "Yes, delete it!"
                        }).then((result) => {
                            if (result.value) {
                                fetch("{{ route('todos.scratchpad.destroy', ':id') }}".replace(':id', id), {
                                        method: 'DELETE',
                                        headers: headers
                                    })
                                    .then(res => res.json())
                                    .then(res => {
                                        if (res.success) _loadNotes();
                                    });
                            }
                        });
                    },
                    moveNote: function(id, direction) {
                        // Direction: -1 (up), 1 (down)
                        // Simple logic: Load all notes, swap order locally, then send full order to server
                        const container = document.getElementById('notepad_container');
                        let ids = Array.from(container.children).map(el => parseInt(el.id.replace('note_', '')));
                        const currentIndex = ids.indexOf(id);
                        if (currentIndex === -1) return;

                        const newIndex = currentIndex + direction;
                        if (newIndex < 0 || newIndex >= ids.length) return;

                        // Swap
                        [ids[currentIndex], ids[newIndex]] = [ids[newIndex], ids[currentIndex]];

                        fetch("{{ route('todos.scratchpad.reorder') }}", {
                                method: 'PUT',
                                headers: headers,
                                body: JSON.stringify({
                                    order: ids
                                })
                            })
                            .then(res => res.json())
                            .then(res => {
                                if (res.success) _loadNotes();
                            });
                    }
                }
            }();

            jQuery(document).ready(function() {
                TodoApp.init();
            });
        </script>
    @endpush
</x-metrolar-layout>
