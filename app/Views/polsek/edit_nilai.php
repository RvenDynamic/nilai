<?php
/**
 * @var CodeIgniter\View\View $this
*/
?>
<?= $this->extend("/polsek/layout/index") ?>
<?= $this->section("content") ?>

<div class="xl:mx-60 lg:mx-48 md:mx-28 sm:mx-20 mx-10 mt-24">
    <div class="max-w-full mx-auto">
        <div class="flex flex-col items-center bg-white dark:bg-gray-800 p-7 rounded-lg mt-10">
            <h2 class="mb-5 text-gray-900 dark:text-gray-200 font-bold text-xl text-center">Edit Nilai <?= $mapel ?>
                '<?= $nilai['tahun'] ?>'
            </h2>
            <form
                action="<?= base_url('/polsek/edit-nilai/') ?><?=  $mapel == "mental" ?  $nilai['mental_id']. '?mapel='. $mapel : $nilai['rohani_id']. '?mapel='. $mapel ?>"
                method="post" enctype="multipart/form-data">
                <label for="nilai" class="my-2 text-sm font-light text-gray-500 dark:text-gray-200">Nilai</label>
                <input type="number" step="0.01"
                    class="w-full px-6 py-3 mb-2 border border-slate-600 rounded-lg font-medium dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                    value="<?= $nilai['nilai'] ?>" name="nilai" id="nilai" />
                <img data-modal-target="bukti-edit-<?= $nilai['bukti'] ?>"
                    data-modal-toggle="bukti-edit-<?= $nilai['bukti'] ?>"
                    src="<?= base_url('/resource/bukti_nilai/'. $nilai['bukti']) ?>" alt="bukti"
                    class="w-full rounded-md h-52 md:object-fill object-cover my-2 cursor-pointer hover:shadow-xl hover:ring-2">

                <button type="submit"
                    class="bg-slate-500 dark:bg-slate-600 font-extrabold hover:bg-slate-700 text-white text-base rounded-lg py-2.5 px-5 transition-colors w-full text-[19px] my-2">Simpan</button>
            </form>
        </div>
    </div>
</div>

<!-- bukti nilai emental modal -->
<div id="bukti-edit-<?= $nilai['bukti'] ?>" tabindex="-1"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-4xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                    Bukti Nilai <?= $nilai['tahun'] ?>
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="bukti-edit-<?= $nilai['bukti'] ?>">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Kembali</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4 flex justify-center">
                <img src="<?= base_url('/resource/bukti_nilai/'. $nilai['bukti']) ?>" alt="bukti" class="rounded-sm">
            </div>
        </div>
    </div>
</div>

<script>
// alert error 
<?php if (!empty(session()->getFlashdata("error_edit_nilai"))) : ?>
document.addEventListener("DOMContentLoaded", () => {
    Swal.fire({
        title: "error!",
        icon: "error",
        html: `<?= session('error_edit_nilai') ?>`
    });
})
<?php endif; ?>
</script>

<?= $this->endSection() ?>