<x-metrolar-layout>
    <x-slot name="title">Servers</x-slot>
    <x-slot name="subheader">
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Servers</h5>
                </div>
                <div class="d-flex align-items-center">
                    <button type="button" class="btn btn-primary font-weight-bold" data-toggle="modal"
                        data-target="#kt_modal_server" id="btn_open_create_modal">
                        <i class="flaticon2-plus-1"></i> Add Server
                    </button>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="card card-custom gutter-b">
        <div class="card-header border-0 py-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label font-weight-bolder text-dark">Server Infrastructure</span>
                <span class="text-muted mt-3 font-weight-bold font-size-sm">Manage your servers and nodes</span>
            </h3>
        </div>
        <div class="card-body py-0">
            <div class="table-responsive">
                <table class="table table-head-custom table-vertical-center" id="kt_server_table">
                    <thead>
                        <tr class="text-left">
                            <th style="min-width: 150px">Name</th>
                            <th style="min-width: 120px">IP Address</th>
                            <th style="min-width: 100px">Type</th>
                            <th style="min-width: 100px">Status</th>
                            <th class="text-right pr-0" style="min-width: 100px">Action</th>
                        </tr>
                    </thead>
                    <tbody id="server_list_container">
                        <!-- Loaded via JS -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal-->
    <div class="modal fade" id="kt_modal_server" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="kt_form_server">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Server Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="server_id" name="id">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" id="server_name"
                                        placeholder="Server Name" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Server Type <span class="text-danger">*</span></label>
                                    <select class="form-control" name="server_type" id="server_type" required>
                                        <option value="VPS">VPS</option>
                                        <option value="Physical">Physical</option>
                                        <option value="Cloud">Cloud</option>
                                        <option value="Container">Container</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>IP Address <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="ip_address" id="server_ip_address"
                                        placeholder="192.168.1.1 or domain.com" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Port <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="port" id="server_port"
                                        value="22" required />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Username <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="username" id="server_username"
                                        placeholder="root" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>OS Type <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="os_type" id="server_os_type"
                                        placeholder="Ubuntu 22.04" required />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Password (Leave blank to keep unchanged)</label>
                            <input type="password" class="form-control" name="password" id="server_password"
                                placeholder="Password" />
                        </div>

                        <div class="form-group">
                            <label>Private Key</label>
                            <textarea class="form-control" name="private_key" id="server_private_key" rows="3"
                                style="font-family:monospace; font-size: 0.8rem;"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Public Key</label>
                            <textarea class="form-control" name="public_key" id="server_public_key" rows="2"
                                style="font-family:monospace; font-size: 0.8rem;"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" name="description" id="server_description" rows="2"></textarea>
                        </div>

                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="server_is_active" name="is_active"
                                value="1" checked>
                            <label class="form-check-label" for="server_is_active">Active</label>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold"
                            data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary font-weight-bold" id="btn_save_server">Save
                            changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            "use strict";

            const headers = {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            };

            const ServerApp = function() {
                const _loadServers = () => {
                    KTApp.block('#kt_server_table', {
                        overlayColor: '#000000',
                        state: 'primary',
                        message: 'Processing...'
                    });

                    fetch("{{ route('servers.list') }}", {
                            method: 'GET',
                            headers: headers
                        })
                        .then(response => response.json())
                        .then(res => {
                            KTApp.unblock('#kt_server_table');
                            if (res.success) {
                                _renderTable(res.data);
                            }
                        })
                        .catch(err => {
                            KTApp.unblock('#kt_server_table');
                            console.error(err);
                            toastr.error("Failed to load servers");
                        });
                };

                const _renderTable = (data) => {
                    const container = document.getElementById('server_list_container');
                    container.innerHTML = '';

                    if (data.length === 0) {
                        container.innerHTML =
                            '<tr><td colspan="5" class="text-center text-muted">No servers found</td></tr>';
                        return;
                    }

                    data.forEach(item => {
                        const statusBadge = item.is_active ?
                            '<span class="label label-light-success label-inline font-weight-bold">Active</span>' :
                            '<span class="label label-light-danger label-inline font-weight-bold">Inactive</span>';

                        const editBtn = `
                            <a href="javascript:;" class="btn btn-icon btn-light btn-hover-primary btn-sm mx-3"
                                onclick="ServerApp.editItem(${item.id})">
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
                                onclick="ServerApp.deleteItem(${item.id})">
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

                        // Store full object in memory for edit (simpler than data attributes for large objects)
                        window[`server_${item.id}`] = item;

                        const row = `
                            <tr>
                                <td>
                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">${item.name}</span>
                                    <span class="text-muted font-weight-bold">${item.description || ''}</span>
                                </td>
                                <td>
                                    <span class="text-dark-75 font-weight-bold d-block">${item.ip_address}</span>
                                    <span class="text-muted font-size-sm">Port: ${item.port}</span>
                                </td>
                                <td>
                                    <span class="text-dark-75 font-weight-bold">${item.server_type}</span>
                                    <span class="text-muted font-size-sm d-block">${item.os_type}</span>
                                </td>
                                <td>
                                    ${statusBadge}
                                </td>
                                <td class="text-right pr-0">
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

                    const btn = document.getElementById('btn_save_server');
                    const form = document.getElementById('kt_form_server');
                    const id = document.getElementById('server_id').value;
                    const isEdit = !!id;

                    const formData = new FormData(form);
                    // Handle checkbox
                    if (!formData.has('is_active')) {
                        // If unchecked, it won't be in formdata, but we might want to send false?
                        // Actually, FormData works fine, but let's just use Object.fromEntries logic
                    }
                    // For logic consistency with checkbox being "value=1", if unchecked it's missing.
                    // But in JSON API, boolean is better.
                    const data = Object.fromEntries(formData.entries());
                    data.is_active = form.querySelector('#server_is_active').checked ? 1 : 0;

                    KTUtil.btnWait(btn, "spinner spinner-right spinner-white pr-15", "Saving...");

                    const url = isEdit ?
                        "{{ route('servers.update', ':id') }}".replace(':id', id) :
                        "{{ route('servers.store') }}";

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
                                if (response.status === 422 && data && data.errors) {
                                    let errorMsg = '';
                                    Object.values(data.errors).forEach(err => {
                                        errorMsg += err.join('<br>') + '<br>';
                                    });
                                    toastr.error(errorMsg, "Validation Error");
                                } else {
                                    const msg = (data && data.message) || response.statusText;
                                    toastr.error(msg, "Error " + response.status);
                                }
                                return {
                                    success: false
                                };
                            }
                            return data;
                        })
                        .then(res => {
                            KTUtil.btnRelease(btn);
                            if (res && res.success) {
                                $('#kt_modal_server').modal('hide');
                                toastr.success(res.message);
                                _loadServers();
                            }
                        })
                        .catch(err => {
                            KTUtil.btnRelease(btn);
                            console.error(err);
                            toastr.error("An unexpected error occurred.");
                        });
                };

                return {
                    init: function() {
                        _loadServers();
                        document.getElementById('kt_form_server').addEventListener('submit', _handleSubmit);

                        $('#kt_modal_server').on('hidden.bs.modal', function() {
                            document.getElementById('kt_form_server').reset();
                            document.getElementById('server_id').value = '';
                            // Reset checkbox
                            document.getElementById('server_is_active').checked = true;
                        });
                    },
                    editItem: function(id) {
                        const item = window[`server_${id}`];
                        if (!item) return;

                        document.getElementById('server_id').value = item.id;
                        document.getElementById('server_name').value = item.name;
                        document.getElementById('server_ip_address').value = item.ip_address;
                        document.getElementById('server_port').value = item.port;
                        document.getElementById('server_username').value = item.username;
                        document.getElementById('server_os_type').value = item.os_type;
                        document.getElementById('server_server_type').value = item.server_type;
                        document.getElementById('server_private_key').value = item.private_key || '';
                        document.getElementById('server_public_key').value = item.public_key || '';
                        document.getElementById('server_description').value = item.description || '';
                        document.getElementById('server_is_active').checked = !!item.is_active;

                        // Password is purposely empty

                        $('#kt_modal_server').modal('show');
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
                                fetch("{{ route('servers.destroy', ':id') }}".replace(':id', id), {
                                        method: 'DELETE',
                                        headers: headers
                                    })
                                    .then(res => res.json())
                                    .then(res => {
                                        if (res.success) {
                                            toastr.success(res.message);
                                            _loadServers();
                                        }
                                    });
                            }
                        });
                    }
                };
            }();

            jQuery(document).ready(function() {
                ServerApp.init();
            });
        </script>
    @endpush
</x-metrolar-layout>
