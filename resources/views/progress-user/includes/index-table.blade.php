<div class="table-responsive">
    <table class="table table-striped" id="data-table" style="height: 100px;">
        <thead>
            <tr>
                <th>No</th>
                <th class="align-middle">ID Peserta</th>
                <th class="align-middle">Nama</th>
                <th class="align-middle">Course</th>
                <th class="align-middle">Modul</th>
                <th class="align-middle">Section</th>
                <th class="align-middle">Jenis Section</th>
                <th class="align-middle">Waktu Submit</th>
                {{-- <th class="align-middle">Waktu Koreksi</th> --}}
                {{-- <th class="align-middle">Corrector</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($progressUser as $row)
                <tr>
                    <td>{{ $loop->iteration + ($progressUser->currentPage() - 1) * $progressUser->perPage() }}</td>
                    <td>{{ $row?->peserta_id }}</td>
                    <td>{{ $row?->peserta->nama }}</td>
                    <td>{{ $row?->course->judul }}</td>
                    <td>{{ $row?->modul->judul }}</td>
                    <td>{{ $row?->modul_detail->judul }}</td>
                    <td>{{ $row?->section_type }}</td>
                    <td>{{ formatDatetime($row?->waktu_submit, 'datetime') }}</td>
                    {{-- <td>{{ formatDatetime($row?->waktu_koreksi, 'datetime') }}</td> --}}
                    {{-- <td>{{ $row?->corrector->name ?? '' }}</td> --}}
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Pagination --}}
<div class="mt-3 d-flex justify-content-end">
    {!! $progressUser->withQueryString()->links() !!}
</div>
