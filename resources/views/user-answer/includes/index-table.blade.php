<div class="table-responsive">
    <table class="table table-striped" id="data-table" style="height: 100px;">
        <thead>
            <tr>
                <th>No</th>
                <th class="align-middle">ID Peserta</th>
                <th class="align-middle">Nama</th>
                {{-- <th class="align-middle">Section</th> --}}
                <th class="align-middle">Soal</th>
                <th class="align-middle">Tipe Soal</th>
                <th class="align-middle">Text</th>
                <th class="align-middle">Label Jawaban</th>
                <th class="align-middle">Text Jawaban</th>
                <th class="align-middle">Waktu Jawab</th>
                {{-- <th class="align-middle">Status</th> --}}
                {{-- <th class="align-middle">Skor</th> --}}
                {{-- <th class="align-middle">Corrector</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($userAnswer as $row)
                <tr>
                    <td>{{ $loop->iteration + ($userAnswer->currentPage() - 1) * $userAnswer->perPage() }}</td>
                    <td>{{ $row?->peserta_id }}</td>
                    <td>{{ $row?->peserta->nama }}</td>
                    {{-- <td>{{ $row?->modul_detail->judul }}</td> --}}
                    <td>{{ $row?->soal->isi }}</td>
                    <td>{{ get_jenis_soal($row?->soal_tipe) }}</td>
                    <td>{{ $row?->soal_text }}</td>
                    <td>{{ $row?->answer_label }}</td>
                    <td>{{ $row?->answer_text }}</td>
                    <td>{{ formatDatetime($row?->created_at, 'datetime') }}</td>
                    {{-- <td>{{ $row?->is_correct }}</td> --}}
                    {{-- <td>{{ $row?->score }}</td> --}}
                    {{-- <td>{{ $row?->corrector->name ?? '' }}</td> --}}
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Pagination --}}
<div class="mt-3 d-flex justify-content-end">
    {!! $userAnswer->withQueryString()->links() !!}
</div>
