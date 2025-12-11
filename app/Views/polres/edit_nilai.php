<?php
/**
 * @var CodeIgniter\View\View $this
*/
?>
<?= $this->extend("/polres/layout/index") ?>
<?= $this->section("content") ?>

<div class="container mx-auto mt-20 p-5">
    <div class="flex justify-between mb-5 font-extrabold text-xl items-center dark:text-gray-200">
        <a href="<?= base_url("/polres/data-anggota") ?>" class="hover:underline"><i
                class="fa-solid fa-arrow-left-long mr-5"></i>Kembali</a>
        <img src="<?= base_url('/img/Lambang_Polda_Jateng.png') ?>" alt="Logo" width="60px" />
    </div>
    <div class="flex flex-col mb-5 bg-white dark:bg-gray-800 rounded-lg">
        <div class="flex ml-5 mt-10">
            <h1 class="font-bold dark:text-gray-200 ml-10">Nilai Anggota "<?= $anggota['name'] ?>"</h1>
        </div>
        <div class="ml-5 mt-7 md:mt-10 grid md:grid-flow-col dark:text-gray-200 justify-left">
            <label class="ml-10 font-bold" for="nama">Nama : <span
                    class="font-normal"><?= $anggota['name'] ?></span></label>
            <label class="font-bold md:ml-0 md:mt-0 ml-10 mt-4" for="nrp">NRP/NIP : <span class="font-normal"><?= $anggota['nrp'] ?></span></label>
        </div>
        <div class="ml-5 md:mt-8 mt-4 grid md:grid-flow-col dark:text-gray-200 justify-left">
            <label class="ml-10 md:mr-3 font-bold" for="jabatan">Jabatan : <span
                    class="font-normal"><?= $anggota['jabatan'] ?></span></label>
            <label class="font-bold md:ml-28 md:mt-0 ml-10 mt-4" for="satfung">Polsek/Satfung : <span
                    class="font-normal"><?= $anggota['satfung_name'] ?></span></label>
        </div>
        <div class="ml-5 mt-4 md:mt-8 grid grid-flow-col dark:text-gray-200 justify-left">
            <label class="ml-10 font-bold" for="pangkat">Pangkat : <span
                    class="font-normal"><?= $anggota['pangkat_name'] ?></span></label>
        </div>
        <hr class="ml-14 mr-14 mt-5" />
        <div class="w-full my-4 px-20">
            <span class="text-lg font-bold dark:text-gray-200">Filter: tahun "<?= $tahun ?>", semester "<?= $semester ?>",
                e-<?= $mapel ?></span>
        </div>
        <!-- tabel -->
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-16 py-3">Tahun</th>
                        <th scope="col" class="px-16 py-3">Semester</th>
                        <th scope="col" class="px-16 py-3">Nilai</th>
                        <th scope="col" class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($nilai)) : ?>
                    <td class="text-center text-xl font-semibold py-5" colspan="4">Tidak ada data nilai</td>
                    <?php else : ?>
                    <?php foreach($nilai as $key => $value) : ?>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-16 py-4"><?= $value['tahun'] ?></td>
                        <td class="px-16 py-4"><?= $value['semester'] ?></td>
                        <td class="px-16 py-4"><?= $value['nilai'] ?></td>
                        <td class="flex justify-center gap-4 px-6 py-4">
                            <button
                                data-modal-target="bukti-modal-<?=  $mapel === "mental" ? $value['mental_id'] : $value['rohani_id'] ?>"
                                data-modal-toggle="bukti-modal-<?=  $mapel === "mental" ? $value['mental_id'] : $value['rohani_id'] ?>"
                                class="flex justify-center items-center gap-2 font-bold text-blue-600 hover:font-bold border border-blue-600 rounded-full text-center px-3 py-0.5 hover:bg-blue-500 hover:border-blue-800 hover:text-white">
                                <i class="fa-solid fa-image"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- bukti nilai emental modal -->
                    <div id="bukti-modal-<?=  $mapel === "mental" ? $value['mental_id'] : $value['rohani_id'] ?>"
                        tabindex="-1"
                        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative w-full max-w-4xl max-h-full">
                            <!-- Modal content -->
                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                <!-- Modal header -->
                                <div
                                    class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                                        Bukti Nilai e-<?= $mapel ?>
                                    </h3>
                                    <button type="button"
                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                        data-modal-hide="bukti-modal-<?=  $mapel === "mental" ? $value['mental_id'] : $value['rohani_id'] ?>">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                        </svg>
                                        <span class="sr-only">Kembali</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <div class="p-4 md:p-5 space-y-4 flex justify-center">
                                    <img src="<?= base_url('/resource/bukti_nilai/'. $value['bukti']) ?>" alt="bukti"
                                        class="rounded-sm">
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php endforeach; ?>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
        <!-- /tabel -->
    </div>
</div>



<script>
// alert error 
<?php if (!empty(session()->getFlashdata("error_edit"))) : ?>
document.addEventListener("DOMContentLoaded", () => {
    Swal.fire({
        title: "error!",
        icon: "error",
        html: `<?= session('error_edit') ?>`
    });
})
<?php endif; ?>
</script>

<?= $this->endSection() ?>