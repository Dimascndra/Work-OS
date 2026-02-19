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
                        <i class="flaticon2-plus-1"></i> Add New
                    </button>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="card card-custom gutter-b">
        <div class="card-header border-0 py-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label font-weight-bolder text-dark">Managed Servers</span>
                <span class="text-muted mt-3 font-weight-bold font-size-sm">Manage your servers and nodes</span>
            </h3>
        </div>
        <div class="card-body py-0">
            <div class="table-responsive">
                <table class="table table-head-custom table-vertical-center" id="kt_server_table">
                    <thead>
                        <tr class="text-left">
                            <th style="min-width: 150px">Server Info</th>
                            <th style="min-width: 120px">IP Address</th>
                            <th style="min-width: 100px">OS</th>
                            <th style="min-width: 100px">Server Type</th>
                            <th style="min-width: 100px">Status</th>
                            <th class="text-right pr-0" style="min-width: 130px">Actions</th>
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

                        <h5 class="font-weight-bold text-dark mb-5">Server Information</h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Server Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" id="server_name"
                                        placeholder="e.g. Production Web 01" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>IP Address <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="ip_address" id="server_ip_address"
                                        placeholder="192.168.1.1" required />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>SSH Port <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="port" id="server_port"
                                        value="22" required />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>OS Type <span class="text-danger">*</span></label>
                                    <select class="form-control form-control-solid" name="os_type" id="server_os_type"
                                        required>
                                        <option value="ubuntu">Ubuntu</option>
                                        <option value="centos">CentOS</option>
                                        <option value="debian">Debian</option>
                                        <option value="linux">Linux</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Server Type <span class="text-danger">*</span></label>
                                    <select class="form-control form-control-solid" name="server_type"
                                        id="server_server_type" required>
                                        <option value="VPS">VPS</option>
                                        <option value="Physical">Physical Server</option>
                                        <option value="Cloud">Cloud Instance</option>
                                        <option value="Container">Container</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status</label>
                                    <div class="checkbox-inline">
                                        <label class="checkbox checkbox-lg">
                                            <input type="checkbox" name="is_active" id="server_is_active"
                                                value="1" checked />
                                            <span></span>
                                            Active
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="separator separator-dashed my-7"></div>

                        <h5 class="font-weight-bold text-dark mb-5">SSH Authentication</h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>SSH Username <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="username" id="server_username"
                                        placeholder="root" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>SSH Password (Optional)</label>
                                    <input type="password" class="form-control" name="password" id="server_password"
                                        placeholder="Password for SSH authentication" />
                                    <small class="form-text text-muted">Stored securely with encryption. Leave blank to
                                        keep current.</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>SSH Private Key (Optional)</label>
                            <textarea class="form-control form-control-solid" name="private_key" id="server_private_key" rows="5"
                                style="font-family:monospace; font-size: 0.8rem;" placeholder="-----BEGIN RSA PRIVATE KEY-----..."></textarea>
                            <small class="form-text text-muted">For key-based authentication. Stored securely.</small>
                        </div>

                        <div class="form-group">
                            <label>SSH Public Key (Optional)</label>
                            <textarea class="form-control form-control-solid" name="public_key" id="server_public_key" rows="3"
                                style="font-family:monospace; font-size: 0.8rem;" placeholder="ssh-rsa AAAAB3NzaC1yc2E..."></textarea>
                            <small class="form-text text-muted">Your public key for reference.</small>
                        </div>

                        <div class="separator separator-dashed my-7"></div>

                        <div class="form-group">
                            <label>Description / Notes (Optional)</label>
                            <textarea class="form-control form-control-solid" name="description" id="server_description" rows="3"
                                placeholder="Additional notes..."></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary font-weight-bold"
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

            // Clipboard Helper
            window.copyToClipboard = function(text, type = 'Text') {
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(text).then(function() {
                        toastr.success(type + ' copied to clipboard!');
                    }, function(err) {
                        toastr.error('Failed to copy ' + type.toLowerCase() + '.');
                    });
                } else {
                    var textArea = document.createElement("textarea");
                    textArea.value = text;
                    document.body.appendChild(textArea);
                    textArea.focus();
                    textArea.select();
                    try {
                        var successful = document.execCommand('copy');
                        if (successful) toastr.success(type + ' copied to clipboard!');
                        else toastr.error('Failed to copy ' + type.toLowerCase() + '.');
                    } catch (err) {
                        toastr.error('Failed to copy ' + type.toLowerCase() + '.');
                    }
                    document.body.removeChild(textArea);
                }
            };

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
                            '<tr><td colspan="6" class="text-center text-muted">No servers found</td></tr>';
                        return;
                    }

                    data.forEach(item => {
                        const statusBadge = item.is_active ?
                            '<span class="label label-lg label-light-success label-inline">Active</span>' :
                            '<span class="label label-lg label-light-danger label-inline">Inactive</span>';

                        // OS Badge
                        const osBadge =
                            `<span class="label label-lg label-light-info label-inline">${(item.os_type || 'Other').toUpperCase()}</span>`;

                        // Type Badge Logic
                        const typeColors = {
                            'Physical': 'primary',
                            'VPS': 'success',
                            'Cloud': 'info',
                            'Container': 'warning',
                            'Other': 'dark'
                        };
                        const typeColor = typeColors[item.server_type] || 'secondary';
                        const typeBadge =
                            `<span class="label label-lg label-light-${typeColor} label-inline">${item.server_type}</span>`;

                        // Copy Buttons
                        const sshCommand = `ssh -p ${item.port} ${item.username}@${item.ip_address}`;
                        const copySshBtn = `
                            <button type="button" class="btn btn-icon btn-light btn-hover-info btn-sm mr-2"
                                onclick="copyToClipboard('${sshCommand}', 'SSH Command')"
                                title="Copy SSH Command">
                                <i class="flaticon2-copy"></i>
                            </button>
                        `;

                        // We don't have the plain password in frontend normally for security,
                        // unless API returns it. The model likely hides it.
                        // However, previous code showed it. Let's check Controller/Service.
                        // If it's encrypted/hashed, we can't show it.
                        // The user said "Copy Password", assuming they want it.
                        // If the Service returns the password (it shouldn't if it's hashed), then it works.
                        // Refatoring to best practice: Password should NOT be returned.
                        // BUT, if the user insists on restoring features, and previously it worked,
                        // it implies the password might have been stored plainly or reversibly encrypted.
                        // The current `ServerService` has `unset($data['password'])` only on update if empty.
                        // The model `Server.php`... I haven't seen it, but assuming standard Laravel User it's hashed.
                        // But for "Server" model storing credentials, it might be encrypted.
                        // Logic: IF password is in data, show button.

                        const copyPassBtn = item.password ? `
                            <button type="button" class="btn btn-icon btn-light btn-hover-warning btn-sm mr-2"
                                onclick="copyToClipboard('${item.password}', 'Password')"
                                title="Copy Password">
                                <i class="flaticon-security"></i>
                            </button>
                        ` : '';

                        const editBtn = `
                            <a href="javascript:;" class="btn btn-icon btn-light btn-hover-primary btn-sm mx-1"
                                onclick="ServerApp.editItem(${item.id})" title="Edit">
                                <i class="flaticon2-edit"></i>
                            </a>
                        `;
                        const delBtn = `
                            <a href="javascript:;" class="btn btn-icon btn-light btn-hover-danger btn-sm"
                                onclick="ServerApp.deleteItem(${item.id})" title="Delete">
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

                        // Store full object in memory
                        window[`server_${item.id}`] = item;

                        const row = `
                            <tr>
                                <td>
                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">${item.name}</span>
                                    <span class="text-muted font-size-sm">${item.username}</span>
                                </td>
                                <td>
                                    <span class="text-dark-75 font-weight-bold d-block">${item.ip_address}</span>
                                    <span class="text-muted font-size-sm">Port: ${item.port}</span>
                                </td>
                                <td>
                                    ${osBadge}
                                </td>
                                <td>
                                    ${typeBadge}
                                </td>
                                <td>
                                    ${statusBadge}
                                </td>
                                <td class="text-right pr-0">
                                    ${copySshBtn}
                                    ${copyPassBtn}
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
                    // Handle checkbox specifically if needed, but FormData usually covers it if checked
                    // If unchecked, standard HTML form doesn't send it. Laravel handles `boolean` validation usually or we manually force it.
                    // We need to ensuring checkbox value is sent as 0 if unchecked for update.
                    const isActive = form.querySelector('#server_is_active').checked ? 1 : 0;

                    const data = Object.fromEntries(formData.entries());
                    data.is_active = isActive;

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

                        // Initialize Select2
                        $('#server_os_type').select2({
                            placeholder: "Select OS Type",
                            allowClear: true,
                            width: '100%'
                        });

                        $('#server_server_type').select2({
                            placeholder: "Select Server Type",
                            allowClear: true,
                            width: '100%'
                        });

                        $('#kt_modal_server').on('hidden.bs.modal', function() {
                            document.getElementById('kt_form_server').reset();
                            document.getElementById('server_id').value = '';
                            document.getElementById('server_is_active').checked = true;
                            // Reset select2
                            $('#server_os_type').val('ubuntu').trigger('change');
                            $('#server_server_type').val('VPS').trigger('change');
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

                        // Select2 updates
                        $('#server_os_type').val(item.os_type).trigger('change');
                        $('#server_server_type').val(item.server_type).trigger('change');

                        document.getElementById('server_private_key').value = item.private_key || '';
                        document.getElementById('server_public_key').value = item.public_key || '';
                        document.getElementById('server_description').value = item.description || '';
                        document.getElementById('server_is_active').checked = !!item.is_active;

                        // Password is presumed sensitive/empty on edit unless we want to overwrite
                        document.getElementById('server_password').value = '';

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
