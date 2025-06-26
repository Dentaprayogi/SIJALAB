 {{-- Modal Edit --}}
 <div class="modal fade" id="editModal{{ $sesi->id_sesi_jam }}" tabindex="-1"
     aria-labelledby="editModalLabel{{ $sesi->id_sesi_jam }}" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <form action="{{ route('sesi-jam.update', $sesi->id_sesi_jam) }}" method="POST">
                 @csrf
                 @method('PUT')
                 <input type="hidden" name="id_sesi_jam" value="{{ $sesi->id_sesi_jam }}">
                 <div class="modal-header">
                     <h5 class="modal-title">Edit Sesi Jam</h5>
                     <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"
                         onclick="location.reload();">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <div class="modal-body">
                     <div class="mb-3">
                         <label>Nama Sesi</label>
                         <input type="text" name="nama_sesi" class="form-control" value="{{ $sesi->nama_sesi }}"
                             required>
                     </div>
                     <div class="mb-3">
                         <label>Jam Mulai</label>
                         <input type="time" name="jam_mulai" class="form-control" value="{{ $sesi->jam_mulai }}"
                             required>
                     </div>
                     <div class="mb-3">
                         <label>Jam Selesai</label>
                         <input type="time" name="jam_selesai" class="form-control" value="{{ $sesi->jam_selesai }}"
                             required>
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                         onclick="location.reload();">Batal</button>
                     <button type="submit" class="btn btn-primary">Simpan</button>
                 </div>
             </form>
         </div>
     </div>
 </div>
