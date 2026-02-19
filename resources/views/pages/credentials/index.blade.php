<<<<<<< HEAD
<x-metrolar-layout title="Credentials">
    <x-card title="Credentials List">
        <x-slot:toolbar>
            <a href="{{ route('credentials.create') }}" class="btn btn-primary btn-sm font-weight-bolder">
                <i class="ki ki-plus icon-sm"></i> Add New
            </a>
        </x-slot:toolbar>

        <div class="table-responsive">
            <table class="table table-head-custom table-vertical-center" id="kt_advance_table_widget_1">
                <thead>
                    <tr class="text-left">
                        <th style="min-width: 150px">Service</th>
                        <th style="min-width: 150px">Username</th>
                        <th style="min-width: 150px">Category</th>
                        <th style="min-width: 200px">Notes</th>
                        <th class="text-right" style="min-width: 150px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($credentials as $credential)
                        @php
                            $categoryColors = [
                                'personal' => 'primary',
                                'banking' => 'danger',
                                'social' => 'info',
                                'dev' => 'dark',
                                'other' => 'secondary',
                            ];
                            $color = $categoryColors[$credential->category] ?? 'primary';
                        @endphp
                        <tr>
                            <td class="pl-0">
                                <div class="d-flex align-items-center">
                                    @if ($credential->url)
                                        <img src="https://www.google.com/s2/favicons?domain={{ parse_url($credential->url, PHP_URL_HOST) ?? $credential->url }}&sz=32"
                                            class="mr-2 rounded-circle" style="width: 24px; height: 24px;"
                                            alt="" />
                                    @else
                                        <span class="symbol symbol-25 symbol-light-primary mr-2">
                                            <span
                                                class="symbol-label font-size-xs">{{ substr($credential->service_name, 0, 1) }}</span>
                                        </span>
                                    @endif
                                    <div>
                                        <a href="#"
                                            class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">{{ $credential->service_name }}</a>
                                        <span
                                            class="text-muted font-weight-bold text-muted d-block font-size-sm">{{ $credential->url }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span
                                    class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $credential->username }}</span>
                            </td>
                            <td>
                                <span
                                    class="label label-lg label-light-{{ $color }} label-inline font-weight-bold">{{ ucfirst($credential->category) }}</span>
                            </td>
                            <td>
                                <span class="text-muted font-weight-bold" data-toggle="tooltip"
                                    title="{{ $credential->notes }}">{{ Str::limit($credential->notes, 30) }}</span>
                            </td>
                            <td class="text-right pr-0">
                                <a href="javascript:;" class="btn btn-icon btn-light btn-hover-primary btn-sm btn-copy"
                                    data-clipboard-text="{{ $credential->password }}" title="Copy Password">
                                    <span class="svg-icon svg-icon-md svg-icon-primary">
                                        <!-- SVG Copy Icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                            viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <path
                                                    d="M6,9 L6,15 C6,16.6568542 7.34314575,18 9,18 L15,18 L15,18.8181818 C15,20.2324881 14.2324881,21 12.8181818,21 L5.18181818,21 C3.76751186,21 3,20.2324881 3,18.8181818 L3,11.1818182 C3,9.76751186 3.76751186,9 5.18181818,9 L6,9 Z"
                                                    fill="#000000" fill-rule="nonzero" />
                                                <path
                                                    d="M10.1818182,4 L17.8181818,4 C19.2324881,4 20,4.76751186 20,6.18181818 L20,13.8181818 C20,15.2324881 19.2324881,16 17.8181818,16 L10.1818182,16 C8.76751186,16 8,15.2324881 8,13.8181818 L8,6.18181818 C8,4.76751186 8.76751186,4 10.1818182,4 Z"
                                                    fill="#000000" opacity="0.3" />
                                            </g>
                                        </svg>
                                    </span>
                                </a>
                                <a href="{{ route('credentials.edit', $credential) }}"
                                    class="btn btn-icon btn-light btn-hover-primary btn-sm ml-2">
                                    <span class="svg-icon svg-icon-md svg-icon-primary">
                                        <!-- SVG Edit Icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                            viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <path
                                                    d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17633517 8.44974759,4.89206824 L11.3097476,2.06662723 C11.7005417,1.68057262 12.3328789,1.68057262 12.7236731,2.06662723 L15.5836731,4.89206824 C15.8713063,5.17633517 16.0334207,5.56391781 16.0334207,5.96685884 L16.0334207,17.9148182 C16.0334207,18.5262511 15.5358055,19.0210086 14.9221595,19.011685 C14.9126388,19.0115594 14.9031024,19.0114972 14.8935635,19.0114972 L9.13985716,19.0114972 C8.51473722,19.0114972 8,18.5085448 8,17.8971032 L8,17.9148182 Z"
                                                    fill="#000000" fill-rule="nonzero"
                                                    transform="translate(12.016710, 10.505749) rotate(-135.000000) translate(-12.016710, -10.505749) " />
                                                <rect fill="#000000" opacity="0.3" x="5" y="20" width="15"
                                                    height="2" rx="1" />
                                            </g>
                                        </svg>
                                    </span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">No credentials found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
=======
<x-metrolar-layout>
    <x-slot name="title">Credentials</x-slot>
    <x-slot name="subheader">
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Credentials</h5>
                </div>
                <div class="d-flex align-items-center">
                    <button type="button" class="btn btn-primary font-weight-bold" data-toggle="modal"
                        data-target="#kt_modal_credential" id="btn_open_create_modal">
                        <i class="flaticon2-plus-1"></i> Add Credential
                    </button>
                </div>
            </div>
>>>>>>> d4d64e8a3e55c35872a42316b31bfe271b462932
        </div>
    </x-slot>

    <div class="card card-custom gutter-b">
        <div class="card-header border-0 py-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label font-weight-bolder text-dark">Password Manager</span>
                <span class="text-muted mt-3 font-weight-bold font-size-sm">Securely store service credentials</span>
            </h3>
        </div>
        <div class="card-body py-0">
            <div class="table-responsive">
                <table class="table table-head-custom table-vertical-center" id="kt_credential_table">
                    <thead>
                        <tr class="text-left">
                            <th style="min-width: 120px">Service</th>
                            <th style="min-width: 100px">Category</th>
                            <th style="min-width: 150px">Username</th>
                            <th class="text-right pr-0" style="min-width: 100px">Action</th>
                        </tr>
                    </thead>
                    <tbody id="credential_list_container">
                        <!-- Loaded via JS -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal-->
    <div class="modal fade" id="kt_modal_credential" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="kt_form_credential">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Credential Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="credential_id" name="id">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Service Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="service_name"
                                        id="cred_service_name" placeholder="e.g. AWS" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Category <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="category" id="cred_category"
                                        placeholder="e.g. Infrastructure" required />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Username <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="username" id="cred_username"
                                        required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="password" id="cred_password"
                                            required />
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary" type="button"
                                                onclick="CredentialApp.generatePassword()">Gen</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>URL</label>
                            <input type="url" class="form-control" name="url" id="cred_url"
                                placeholder="https://..." />
                        </div>

                        <div class="form-group">
                            <label>Notes</label>
                            <textarea class="form-control" name="notes" id="cred_notes" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold"
                            data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary font-weight-bold" id="btn_save_credential">Save
                            changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
<<<<<<< HEAD
            // Initialize Clipboard.js
            $(function() {
                // Initialize Clipboard.js
                var clipboard = new ClipboardJS('.btn-copy');

                clipboard.on('success', function(e) {
                    var btn = $(e.trigger);
                    var originalTitle = btn.attr('title');

                    // Visual feedback
                    btn.addClass('btn-success').removeClass('btn-light');
                    btn.find('i, svg').addClass('text-white'); // Ensure icon is visible if needed

                    // Show tooltip or feedback
                    if (typeof toastr !== 'undefined') {
                        toastr.success('Password copied to clipboard!');
                    } else {
                        // Fallback if toastr is not available
                        // You might want to use a tooltip update here instead
                    }

                    // Reset button after 2 seconds
                    setTimeout(function() {
                        btn.removeClass('btn-success').addClass('btn-light');
                        btn.find('i, svg').removeClass('text-white');
                        e.clearSelection();
                    }, 2000);
                });
=======
            "use strict";

            const headers = {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            };

            const CredentialApp = function() {
                const _loadCredentials = () => {
                    KTApp.block('#kt_credential_table', {
                        overlayColor: '#000000',
                        state: 'primary',
                        message: 'Processing...'
                    });

                    fetch("{{ route('credentials.list') }}", {
                            method: 'GET',
                            headers: headers
                        })
                        .then(response => response.json())
                        .then(res => {
                            KTApp.unblock('#kt_credential_table');
                            if (res.success) {
                                _renderTable(res.data);
                            }
                        })
                        .catch(err => {
                            KTApp.unblock('#kt_credential_table');
                            console.error(err);
                            toastr.error("Failed to load credentials");
                        });
                };

                const _renderTable = (data) => {
                    const container = document.getElementById('credential_list_container');
                    container.innerHTML = '';

                    if (data.length === 0) {
                        container.innerHTML =
                            '<tr><td colspan="4" class="text-center text-muted">No credentials found</td></tr>';
                        return;
                    }

                    data.forEach(item => {
                        const editBtn = `
                            <a href="javascript:;" class="btn btn-icon btn-light btn-hover-primary btn-sm mx-3"
                                onclick="CredentialApp.editItem(${item.id})">
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
                                onclick="CredentialApp.deleteItem(${item.id})">
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

                        window[`cred_${item.id}`] = item;

                        const row = `
                            <tr>
                                <td>
                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">${item.service_name}</span>
                                    ${item.url ? `<a href="${item.url}" target="_blank" class="text-muted font-size-sm">${item.url}</a>` : ''}
                                </td>
                                <td>
                                    <span class="label label-light-primary label-inline font-weight-bold">${item.category}</span>
                                </td>
                                <td>
                                    <span class="text-dark-75 font-weight-bold">${item.username}</span>
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

                    const btn = document.getElementById('btn_save_credential');
                    const form = document.getElementById('kt_form_credential');
                    const id = document.getElementById('credential_id').value;
                    const isEdit = !!id;

                    const formData = new FormData(form);
                    const data = Object.fromEntries(formData.entries());

                    KTUtil.btnWait(btn, "spinner spinner-right spinner-white pr-15", "Saving...");

                    const url = isEdit ?
                        "{{ route('credentials.update', ':id') }}".replace(':id', id) :
                        "{{ route('credentials.store') }}";

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
                                $('#kt_modal_credential').modal('hide');
                                toastr.success(res.message);
                                _loadCredentials();
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
                        _loadCredentials();
                        document.getElementById('kt_form_credential').addEventListener('submit', _handleSubmit);

                        $('#kt_modal_credential').on('hidden.bs.modal', function() {
                            document.getElementById('kt_form_credential').reset();
                            document.getElementById('credential_id').value = '';
                        });
                    },
                    editItem: function(id) {
                        const item = window[`cred_${id}`];
                        if (!item) return;

                        document.getElementById('credential_id').value = item.id;
                        document.getElementById('cred_service_name').value = item.service_name;
                        document.getElementById('cred_category').value = item.category;
                        document.getElementById('cred_username').value = item.username;
                        document.getElementById('cred_password').value = item.password;
                        document.getElementById('cred_url').value = item.url || '';
                        document.getElementById('cred_notes').value = item.notes || '';

                        $('#kt_modal_credential').modal('show');
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
                                fetch("{{ route('credentials.destroy', ':id') }}".replace(':id', id), {
                                        method: 'DELETE',
                                        headers: headers
                                    })
                                    .then(res => res.json())
                                    .then(res => {
                                        if (res.success) {
                                            toastr.success(res.message);
                                            _loadCredentials();
                                        }
                                    });
                            }
                        });
                    },
                    generatePassword: function() {
                        const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+";
                        let retVal = "";
                        for (let i = 0, n = charset.length; i < 16; ++i) {
                            retVal += charset.charAt(Math.floor(Math.random() * n));
                        }
                        document.getElementById('cred_password').value = retVal;
                    }
                };
            }();

            jQuery(document).ready(function() {
                CredentialApp.init();
>>>>>>> d4d64e8a3e55c35872a42316b31bfe271b462932
            });
        </script>
    @endpush
</x-metrolar-layout>
