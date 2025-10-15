@extends('layouts.app')

@section('content')
    <h2>Distributions</h2>
    <a href="{{ route('distributions.create') }}">Add New Distribution</a>

    <table id="dt-distributions" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Tanggal Distribusi</th>
                <th>Barista</th>
                <th>Total Qty</th>
                <th>Estimasi Penjualan</th>
                <th>Notes</th>
                <th>Aksi</th>
            </tr>
        </thead>
    </table>


    <div id="detail-modal"
        style="display:none;padding:20px;background:#fff;border:1px solid #ddd;position:fixed;left:20%;top:20%;width:60%;z-index:9999;">
        <button id="close-detail">Close</button>
        <div id="detail-body"></div>
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
                    { data: 'notes' },
                    {
                        data: 'id', render: function (d, t, r) {
                            return '<a href="/distributions/' + d + '">Detail</a> | <a href="/distributions/' + d + '" class="del" data-id="' + d + '">Hapus</a>';
                        }
                    }
                ]
            });


            $(document).on('click', '.del', function (e) {
                e.preventDefault();
                if (!confirm('Hapus distribusi ini?')) return;
                var id = $(this).data('id');
                $.ajax({ url: '/distributions/' + id, method: 'DELETE', data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                }, success: function () { table.ajax.reload(); } });
            });
        });

        console.log($('meta[name="csrf-token"]').attr('content'))
    </script>
@endpush
