@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-semibold text-secondary">Daftar Distribusi Produk</h3>
        <a href="{{ route('distributions.create') }}" class="btn btn-primary">+ Tambah Distribusi</a>
    </div>


    <table id="dt-distributions" class="table table-bordered table-striped align-middle">
        <thead class="table-light">
            <tr>
                <th>Tanggal</th>
                <th>Barista</th>
                <th>Total Qty</th>
                <th>Estimasi Penjualan</th>
                <th>Catatan</th>
                <th>Aksi</th>
            </tr>
        </thead>
    </table>

    <!-- Modal Detail -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="detailModalLabel">Detail Distribusi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="modal-body-content" class="p-2 text-secondary"></div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $(function () {
            var table = $('#dt-distributions').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: '{{ route('distributions.data') }}',
                    dataSrc: 'data'
                },
                columns: [
                    { data: 'created_at' },
                    { data: 'barista' },
                    { data: 'total_qty' },
                    { data: 'estimated_result' },
                    {
                        data: 'notes', render: function (d) {
                            if (!d || d.trim() === '') {
                                return '<span class="text-muted">N/A</span>';
                            }
                            return d;
                        }
                    },
                    {
                        data: 'id', render: function (d) {
                            return `<div class='btn-group'>
                              <button class='btn btn-sm btn-outline-primary show-detail' data-id='${d}'>Detail</button>
                              <button class='btn btn-sm btn-outline-danger del' data-id='${d}'>Hapus</button>
                              </div>`;
                        }
                    }
                ]
            });

            // Load detail into modal
            $(document).on('click', '.show-detail', function () {
                var id = $(this).data('id');
                $('#modal-body-content').html('<p class="text-center text-muted">Memuat detail...</p>');
                $('#detailModal').modal('show');
                $.get('/distributions/' + id, function (res) {
                    $('#modal-body-content').html(res);
                });
            });

            $(document).on('click', '.del', function () {
                if (!confirm('Yakin ingin menghapus distribusi ini?')) return;
                $.ajax({ url: '/distributions/' + $(this).data('id'), method: 'DELETE', data: { _token: '{{ csrf_token() }}' }, success: function () { table.ajax.reload(); } });
            });
        });
    </script>
@endpush