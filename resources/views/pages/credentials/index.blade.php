<x-metrolar-layout title="Credentials">
    <x-card title="Credentials List">
        <x-slot:toolbar>
            <a href="{{ route('credentials.create') }}" class="btn btn-primary btn-sm font-weight-bolder">
                <i class="ki ki-plus icon-sm"></i> Add New
            </a>
        </x-slot:toolbar>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="ki ki-check-circle mr-2"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        {{-- Realtime Filter --}}
        <div class="d-flex align-items-center flex-wrap mb-5" style="gap: 12px;">
            {{-- Search --}}
            <div class="input-icon flex-grow-1" style="min-width: 220px;">
                <input type="text" id="credential-search" class="form-control form-control-solid"
                    placeholder="Search service, username, notes..." />
                <span><i class="flaticon2-search-1 text-muted"></i></span>
            </div>
            {{-- Filter by Service --}}
            <div style="min-width: 200px;">
                <select id="credential-service-filter" class="form-control form-control-solid select2"
                    style="width:100%">
                    <option value="">All Services</option>
                    @foreach ($credentials->pluck('service_name')->unique()->sort() as $svc)
                        <option value="{{ strtolower($svc) }}">{{ $svc }}</option>
                    @endforeach
                </select>
            </div>
            {{-- Filter by Category --}}
            <div style="min-width: 180px;">
                <select id="credential-category-filter" class="form-control form-control-solid select2"
                    style="width:100%">
                    <option value="">All Categories</option>
                    <option value="personal">Personal</option>
                    <option value="dev">Development</option>
                    <option value="social">Social Media</option>
                    <option value="banking">Banking</option>
                    <option value="other">Other</option>
                </select>
            </div>
        </div>

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
                            $notes = $credential->notes;
                            $notesAvailable = $credential->notesIsDecryptable();
                            $password = $credential->password;
                            $passwordAvailable = $credential->passwordIsDecryptable() && filled($password);
                        @endphp
                        <tr class="credential-row" data-service="{{ strtolower($credential->service_name) }}"
                            data-username="{{ strtolower($credential->username) }}"
                            data-notes="{{ strtolower($credential->notes) }}"
                            data-category="{{ $credential->category }}">
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
                                        <a href="{{ $credential->url }}"
                                            class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">{{ $credential->service_name }}
                                            <span
                                                class="text-muted font-weight-bold text-muted d-block font-size-sm">{{ $credential->url }}</span></a>
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
                                    title="{{ $notesAvailable ? $notes : 'Unable to decrypt notes with the current app key.' }}">
                                    {{ $notesAvailable ? Str::limit($notes, 30) : 'Unavailable' }}
                                </span>
                            </td>
                            <td class="text-right pr-0">
                                <a href="javascript:;"
                                    class="btn btn-icon btn-light btn-hover-primary btn-sm {{ $passwordAvailable ? 'btn-copy' : 'disabled' }}"
                                    data-clipboard-text="{{ $passwordAvailable ? $password : '' }}"
                                    title="{{ $passwordAvailable ? 'Copy Password' : 'Password cannot be decrypted with the current app key.' }}"
                                    aria-disabled="{{ $passwordAvailable ? 'false' : 'true' }}">
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
                            <td colspan="5" class="text-center text-muted">No credentials found</td>
                        </tr>
                    @endforelse
                    <tr id="no-filter-results" style="display:none;">
                        <td colspan="5" class="text-center text-muted py-5">
                            <i class="flaticon2-search-1 mr-2"></i>No credentials match your search.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </x-card>

    @push('scripts')
        <script>
            $(function() {
                // Initialize Clipboard.js
                var clipboard = new ClipboardJS('.btn-copy');
                clipboard.on('success', function(e) {
                    var btn = $(e.trigger);
                    btn.addClass('btn-success').removeClass('btn-light');
                    btn.find('i, svg').addClass('text-white');
                    if (typeof toastr !== 'undefined') {
                        toastr.success('Password copied to clipboard!');
                    }
                    setTimeout(function() {
                        btn.removeClass('btn-success').addClass('btn-light');
                        btn.find('i, svg').removeClass('text-white');
                        e.clearSelection();
                    }, 2000);
                });

                // Initialize Select2
                $('#credential-service-filter').select2({
                    placeholder: 'All Services',
                    allowClear: true
                });
                $('#credential-category-filter').select2({
                    placeholder: 'All Categories',
                    allowClear: true
                });

                // Realtime Filter
                function applyFilters() {
                    var search = $('#credential-search').val().toLowerCase().trim();
                    var service = $('#credential-service-filter').val() || '';
                    var category = $('#credential-category-filter').val() || '';
                    var visibleCount = 0;

                    $('.credential-row').each(function() {
                        var rowService = $(this).data('service') || '';
                        var rowUsername = $(this).data('username') || '';
                        var rowNotes = $(this).data('notes') || '';
                        var rowCat = $(this).data('category') || '';

                        var matchSearch = !search || rowService.includes(search) || rowUsername.includes(
                            search) || rowNotes.includes(search);
                        var matchService = !service || rowService === service;
                        var matchCategory = !category || rowCat === category;

                        if (matchSearch && matchService && matchCategory) {
                            $(this).show();
                            visibleCount++;
                        } else {
                            $(this).hide();
                        }
                    });

                    $('#no-filter-results').toggle(visibleCount === 0);
                }

                $('#credential-search').on('keyup input', applyFilters);
                // Select2 fires 'change' on select/clear
                $('#credential-service-filter, #credential-category-filter').on('change', applyFilters);
            });
        </script>
    @endpush
</x-metrolar-layout>
