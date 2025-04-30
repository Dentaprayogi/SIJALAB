<table class="table table-striped table-bordered" id="{{ $tableId }}" width="100%" cellspacing="0">
    <thead class="thead-primary">
        <tr>
            <th><input type="checkbox" id="select-all"></th>
            <th>No.</th>
            <th>Hari</th>
            <th>Lab</th>
            <th>Jam</th>
            <th>Mata Kuliah</th>
            <th>Dosen</th>
            <th>Prodi</th>
            <th>Tahun Ajaran</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @if ($data->isEmpty())
            <tr>
                <td colspan="12" class="text-center">Belum Ada Data</td>
            </tr>
        @else
            @foreach ($data as $item)
                <tr>
                    <td><input type="checkbox" class="select-item" name="selected[]" value="{{ $item->id_jadwalLab }}"></td>                                  
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->hari->nama_hari }}</td>
                    <td>{{ $item->lab->nama_lab }}</td>
                    <td>{{ $item->rentang_jam }}</td>                                  
                    <td>{{ $item->mataKuliah->nama_mk }}</td>
                    <td>{{ $item->dosen->nama_dosen }}</td>
                    <td>{{ $item->prodi->kode_prodi }} ({{ $item->kelas->nama_kelas }})</td>
                    <td>{{ $item->tahunAjaran->tahun_ajaran }} ({{ ucfirst($item->tahunAjaran->semester) }})</td>
                    <td>
                        <div class="form-switch-toggle">
                            @php
                                $id = $item->id_jadwalLab;
                            @endphp
                    
                            <input type="hidden" name="status_jadwalLab" id="status_jadwalLab_hidden_{{ $id }}" value="{{ $item->status_jadwalLab }}">
                    
                            <input type="checkbox"
                                id="status_jadwalLab_switch_{{ $id }}"
                                class="switch-toggle jadwalLab-toggle"
                                data-id="{{ $id }}"
                                {{ $item->status_jadwalLab == 'aktif' ? 'checked' : '' }}>
                                
                            <label for="status_jadwalLab_switch_{{ $id }}" class="switch-label"></label>
                            <span id="status_jadwalLab_text_{{ $id }}">{{ $item->status_jadwalLab == 'aktif' ? 'Aktif' : 'Nonaktif' }}</span>
                        </div>
                    </td>                                                                                                         
                    <td>
                        <a href="{{ route('jadwal_lab.edit', $item->id_jadwalLab) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('jadwal_lab.destroy', $item->id_jadwalLab) }}" method="POST" style="display:inline-block;" class="form-delete">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-delete" type="button" data-id="{{ $item->id_jadwalLab }}" title="Hapus">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>