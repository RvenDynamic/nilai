<?php
/**
 * @var CodeIgniter\View\View $this
*/
?>
<?= $this->extend("/polres/layout/index") ?>
<?= $this->section("content") ?>

<div class="w-full min-h-screen p-5 mt-10">
    <div class="w-full mt-24 mb-12 xl:mb-0 px-4 mx-auto">
        <div
            class="relative flex flex-col min-w-0 break-words bg-white dark:bg-gray-800 dark:text-gray-200 w-full mb-6 shadow-lg rounded ">
            <div class="rounded-t mb-0 px-4 py-3 border-0">
                <div class="flex flex-wrap items-center">
                    <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                        <h3 class="font-semibold text-base text-blueGray-700">Rekap Nilai e-<?= $mapel ?>
                            '<?= $tahun ?>' semester '<?= $semester ? $semester : '-' ?>' satfung
                            '<?= $satfungName ? $satfungName : '-' ?>'</h3>
                    </div>
                    <div class="relative w-full px-4 max-w-full flex-grow flex-1 text-right">
                        <form action="<?= base_url("polres/cetak-laporan") ?>" method="post">
                            <input type="hidden" name="tahun" value="<?= $tahun ?>">
                            <input type="hidden" name="semester" value="<?= $semester ?>">
                            <input type="hidden" name="satfung" value="<?= $satfung ?>">
                            <input type="hidden" name="mapel" value="<?= $mapel ?>">
                            <button
                                class="bg-green-500 text-white active:bg-green-600 text-xs font-bold uppercase px-4 py-2 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">Cetak
                                Excel</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="block w-full overflow-x-auto">
                <table class="items-center bg-transparent w-full border-collapse ">
                    <thead>

                        <tr>
                            <th
                                class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                Nama Anggota
                            </th>
                            <th
                                class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                Pangkat
                            </th>
                            <th
                                class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                Jabatan
                            </th>
                            <th
                                class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                Polsek/Satfung
                            </th>
                            <th colspan="2"
                                class="px-6 text-center bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold">
                                E-<?= $mapel ?>
                            </th>
                        </tr>
                        <tr>
                            <th colspan="4"
                                class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-center">
                            </th>
                            <th
                                class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-center">
                                Semester
                            </th>
                            <th
                                class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-center">
                                Nilai
                            </th>
                    </thead>

                    <tbody>
                        <?php if (empty($rekap)) : ?>
                        <tr>
                            <th colspan="7">Data Nilai Tidak Ada</th>
                        </tr>
                        <?php else : ?>
                        <?php foreach($rekap as $key => $value) : ?>
                        <tr>
                            <th
                                class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 ">
                                <?= $value['anggota_name'] ?>
                            </th>
                            <th
                                class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 ">
                                <?= $value['pangkat_name'] ?>
                            </th>
                            <th
                                class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 ">
                                <?= $value['jabatan'] ?>
                            </th>
                            <th
                                class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 ">
                                <?= $value['satfung_name'] ?>
                            </th>
                            <th
                                class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-center text-blueGray-700 ">
                                <?= $value['semester'] ?>
                            </th>
                            <th
                                class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-center text-blueGray-700 ">
                                <?= $value['nilai'] ?>
                            </th>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>

<script>
console.log(<?= json_encode($rekap) ?>);
</script>

<?= $this->endSection() ?>