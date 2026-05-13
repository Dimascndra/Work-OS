<x-metrolar-layout>
    <x-slot name="title">Domain Monitors</x-slot>
    <x-slot name="subheader">
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Domain Monitors</h5>
                </div>
                <div class="d-flex align-items-center">
                    <button type="button" class="btn btn-primary font-weight-bold" data-toggle="modal"
                        data-target="#kt_modal_monitor" id="btn_open_create_modal">
                        <i class="flaticon2-plus-1"></i> Add Monitor
                    </button>
                </div>
            </div>
        </div>
    </x-slot>

    {{-- Stats Cards --}}
    <div class="row gutter-b" id="monitor_stats_row">
        <div class="col-md-4">
            <div class="card card-custom bg-primary card-stretch gutter-b">
                <div class="card-body d-flex align-items-center py-7">
                    <div class="mr-5">
                        <span class="svg-icon svg-icon-white svg-icon-3x">
                            <i class="flaticon2-browser-2 text-white" style="font-size:2.5rem;"></i>
                        </span>
                    </div>
                    <div class="text-white">
                        <div class="font-size-sm font-weight-bold opacity-75">Total Monitors</div>
                        <div class="font-size-h2 font-weight-bolder" id="stat_total">–</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-custom bg-success card-stretch gutter-b">
                <div class="card-body d-flex align-items-center py-7">
                    <div class="mr-5">
                        <i class="flaticon2-check-mark text-white" style="font-size:2.5rem;"></i>
                    </div>
                    <div class="text-white">
                        <div class="font-size-sm font-weight-bold opacity-75">Healthy</div>
                        <div class="font-size-h2 font-weight-bolder" id="stat_healthy">–</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-custom bg-warning card-stretch gutter-b">
                <div class="card-body d-flex align-items-center py-7">
                    <div class="mr-5">
                        <i class="flaticon-warning-sign text-white" style="font-size:2.5rem;"></i>
                    </div>
                    <div class="text-white">
                        <div class="font-size-sm font-weight-bold opacity-75">Expiring Soon (≤30 days)</div>
                        <div class="font-size-h2 font-weight-bolder" id="stat_expiring">–</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-custom gutter-b">
        <div class="card-header border-0 py-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label font-weight-bolder text-dark">Monitored Domains</span>
                <span class="text-muted mt-3 font-weight-bold font-size-sm">Track uptime and expiry status</span>
            </h3>
        </div>
        <div class="card-body py-0">
            <div class="table-responsive">
                <table class="table table-head-custom table-vertical-center" id="kt_monitor_table">
                    <thead>
                        <tr class="text-left">
                            <th style="min-width: 180px">Domain URL</th>
                            <th style="min-width: 100px">Status</th>
                            <th style="min-width: 140px">SSL Expiry</th>
                            <th style="min-width: 140px">Domain Expiry</th>
                            <th style="min-width: 120px">Last Checked</th>
                            <th class="text-right pr-0" style="min-width: 120px">Action</th>
                        </tr>
                    </thead>
                    <tbody id="monitor_list_container">
                        <!-- Loaded via JS -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal-->
    <div class="modal fade" id="kt_modal_monitor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="kt_form_monitor">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Monitor Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="monitor_id" name="id">

                        <div class="form-group">
                            <label>Domain URL <span class="text-danger">*</span></label>
                            <input type="url" class="form-control" name="domain_url" id="monitor_domain_url"
                                placeholder="https://example.com" required />
                            <span class="form-text text-muted">
                                <i class="flaticon2-information icon-sm text-info"></i>
                                SSL &amp; Domain expiry akan diambil otomatis saat klik tombol <strong>Ping</strong>.
                            </span>
                        </div>

                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select class="form-control" name="status" id="monitor_status" required>
                                <option value="healthy">Healthy</option>
                                <option value="warning">Warning</option>
                                <option value="down">Down</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold"
                            data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary font-weight-bold" id="btn_save_monitor">Save
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

            const MonitorApp = function() {

                // ─── Helpers ────────────────────────────────────────────────────────────
                const _daysLeft = (dateStr) => {
                    if (!dateStr) return null;
                    const diff = Math.ceil((new Date(dateStr) - new Date()) / (1000 * 60 * 60 * 24));
                    return diff;
                };

                const _expiryBadge = (dateStr) => {
                    const days = _daysLeft(dateStr);
                    if (days === null) return '<span class="text-muted">–</span>';

                    let cls, label;
                    if (days < 0) {
                        cls = 'label-light-danger';
                        label = `Expired ${Math.abs(days)}d ago`;
                    } else if (days <= 7) {
                        cls = 'label-danger';
                        label = `${days}d left`;
                    } else if (days <= 30) {
                        cls = 'label-warning';
                        label = `${days}d left`;
                    } else {
                        cls = 'label-light-success';
                        label = `${days}d left`;
                    }
                    return `<span class="label ${cls} label-inline font-weight-bold">${label}</span>`;
                };

                const _formatDate = (dateStr) => {
                    if (!dateStr) return '';
                    return dateStr.substring(0, 10); // YYYY-MM-DD
                };

                const _timeAgo = (dateStr) => {
                    if (!dateStr) return '<span class="text-muted">Never</span>';
                    const d = new Date(dateStr);
                    const diff = Math.round((new Date() - d) / 60000);
                    if (diff < 1) return '<span class="text-success font-weight-bold">Just now</span>';
                    if (diff < 60) return `<span class="text-muted">${diff}m ago</span>`;
                    if (diff < 1440) return `<span class="text-muted">${Math.round(diff/60)}h ago</span>`;
                    return `<span class="text-muted">${Math.round(diff/1440)}d ago</span>`;
                };

                // ─── Load & Render ───────────────────────────────────────────────────────
                const _loadMonitors = () => {
                    KTApp.block('#kt_monitor_table', {
                        overlayColor: '#000000',
                        state: 'primary',
                        message: 'Processing...'
                    });

                    fetch("{{ route('domain-monitors.list') }}", {
                            method: 'GET',
                            headers: headers
                        })
                        .then(response => response.json())
                        .then(res => {
                            KTApp.unblock('#kt_monitor_table');
                            if (res.success) {
                                _renderTable(res.data);
                                _updateStats(res.data);
                            }
                        })
                        .catch(err => {
                            KTApp.unblock('#kt_monitor_table');
                            console.error(err);
                            toastr.error("Failed to load monitors");
                        });
                };

                const _updateStats = (data) => {
                    const total = data.length;
                    const healthy = data.filter(i => i.status === 'healthy').length;
                    const expiring = data.filter(i => {
                        const d1 = _daysLeft(i.ssl_expires_at);
                        const d2 = _daysLeft(i.domain_expires_at);
                        return (d1 !== null && d1 <= 30) || (d2 !== null && d2 <= 30);
                    }).length;

                    document.getElementById('stat_total').textContent = total;
                    document.getElementById('stat_healthy').textContent = healthy;
                    document.getElementById('stat_expiring').textContent = expiring;
                };

                const _renderTable = (data) => {
                    const container = document.getElementById('monitor_list_container');
                    container.innerHTML = '';

                    if (data.length === 0) {
                        container.innerHTML =
                            '<tr><td colspan="6" class="text-center text-muted py-10">No monitors found</td></tr>';
                        return;
                    }

                    data.forEach(item => {
                        let statusBadge = '';
                        if (item.status === 'healthy') statusBadge =
                            '<span class="label label-light-success label-inline">Healthy</span>';
                        else if (item.status === 'warning') statusBadge =
                            '<span class="label label-light-warning label-inline">Warning</span>';
                        else statusBadge = '<span class="label label-light-danger label-inline">Down</span>';

                        const sslBadge = _expiryBadge(item.ssl_expires_at);
                        const domainBadge = _expiryBadge(item.domain_expires_at);
                        const lastChecked = _timeAgo(item.last_checked_at);

                        const pingBtn = `
                            <a href="javascript:;" title="Ping Domain"
                                class="btn btn-icon btn-light btn-hover-info btn-sm mr-1"
                                onclick="MonitorApp.pingItem(${item.id}, this)">
                                <i class="flaticon2-refresh text-info"></i>
                            </a>
                        `;
                        const editBtn = `
                            <a href="javascript:;" title="Edit"
                                class="btn btn-icon btn-light btn-hover-primary btn-sm mx-1"
                                onclick="MonitorApp.editItem(${item.id})">
                                <span class="svg-icon svg-icon-md svg-icon-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"/>
                                            <path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114732 12.1704054,4.68743216 12.4682693,4.42533086 L14.730303,2.44685117 C15.4219352,1.83407987 16.5165842,1.83856417 17.2036662,2.45780515 C17.8907482,3.07823547 17.8924618,4.17045763 17.2084799,4.78657662 L15.7082305,6.09633807 L15.932849,18.8703358 C15.9084323,19.9238804 15.0110364,20.7308967 14.1206132,20.7634358 L12.8256565,20.8123019 C12.4332219,20.6698964 12.193297,20.3705096 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.749023) rotate(-135.000000) translate(-14.701953, -10.749023)"/>
                                            <path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                        </g>
                                    </svg>
                                </span>
                            </a>
                        `;
                        const delBtn = `
                            <a href="javascript:;" title="Delete"
                                class="btn btn-icon btn-light btn-hover-danger btn-sm ml-1"
                                onclick="MonitorApp.deleteItem(${item.id})">
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

                        window[`monitor_${item.id}`] = item;

                        const row = `
                            <tr id="monitor_row_${item.id}">
                                <td>
                                    <a href="${item.domain_url}" target="_blank" class="text-dark-75 font-weight-bolder d-block font-size-lg text-hover-primary">
                                        ${item.domain_url}
                                    </a>
                                </td>
                                <td>${statusBadge}</td>
                                <td>${sslBadge}</td>
                                <td>${domainBadge}</td>
                                <td>${lastChecked}</td>
                                <td class="text-right pr-0">
                                    ${pingBtn}${editBtn}${delBtn}
                                </td>
                            </tr>
                        `;
                        container.insertAdjacentHTML('beforeend', row);
                    });
                };

                // ─── Form Submit ─────────────────────────────────────────────────────────
                const _handleSubmit = (e) => {
                    e.preventDefault();

                    const btn = document.getElementById('btn_save_monitor');
                    const form = document.getElementById('kt_form_monitor');
                    const id = document.getElementById('monitor_id').value;
                    const isEdit = !!id;

                    const formData = new FormData(form);
                    const data = Object.fromEntries(formData.entries());

                    KTUtil.btnWait(btn, "spinner spinner-right spinner-white pr-15", "Saving...");

                    const url = isEdit ?
                        "{{ route('domain-monitors.update', ':id') }}".replace(':id', id) :
                        "{{ route('domain-monitors.store') }}";

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
                                $('#kt_modal_monitor').modal('hide');
                                toastr.success(res.message);
                                _loadMonitors();
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
                        _loadMonitors();
                        document.getElementById('kt_form_monitor').addEventListener('submit', _handleSubmit);

                        // Initialize Select2
                        $('#monitor_status').select2({
                            placeholder: "Select Status",
                            minimumResultsForSearch: Infinity,
                            width: '100%'
                        });

                        $('#kt_modal_monitor').on('hidden.bs.modal', function() {
                            document.getElementById('kt_form_monitor').reset();
                            document.getElementById('monitor_id').value = '';
                            $('#monitor_status').val('healthy').trigger('change');
                        });
                    },
                    editItem: function(id) {
                        const item = window[`monitor_${id}`];
                        if (!item) return;

                        document.getElementById('monitor_id').value = item.id;
                        document.getElementById('monitor_domain_url').value = item.domain_url;
                        $('#monitor_status').val(item.status).trigger('change');

                        $('#kt_modal_monitor').modal('show');
                    },
                    pingItem: function(id, el) {
                        el.classList.add('spinner', 'spinner-sm', 'spinner-info');
                        el.style.pointerEvents = 'none';

                        fetch("{{ route('domain-monitors.check', ':id') }}".replace(':id', id), {
                                method: 'POST',
                                headers: headers
                            })
                            .then(res => res.json())
                            .then(res => {
                                el.classList.remove('spinner', 'spinner-sm', 'spinner-info');
                                el.style.pointerEvents = '';
                                if (res.success) {
                                    toastr.info(`${res.data.domain_url} → <strong>${res.data.status}</strong>`,
                                        "Ping Result", {
                                            enableHtml: true
                                        });
                                    _loadMonitors();
                                }
                            })
                            .catch(() => {
                                el.classList.remove('spinner', 'spinner-sm', 'spinner-info');
                                el.style.pointerEvents = '';
                                toastr.error("Ping failed");
                            });
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
                                fetch("{{ route('domain-monitors.destroy', ':id') }}".replace(':id', id), {
                                        method: 'DELETE',
                                        headers: headers
                                    })
                                    .then(res => res.json())
                                    .then(res => {
                                        if (res.success) {
                                            toastr.success(res.message);
                                            _loadMonitors();
                                        }
                                    });
                            }
                        });
                    }
                };
            }();

            jQuery(document).ready(function() {
                MonitorApp.init();
            });
        </script>
    @endpush
</x-metrolar-layout>
