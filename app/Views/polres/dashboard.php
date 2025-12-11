<?php
/**
 * @var CodeIgniter\View\View $this
*/
?>
<?= $this->extend("/polres/layout/index") ?>
<?= $this->section("content") ?>

<div class="container mx-auto mt-20 p-5">
    <div class="w-full flex  gap-1 justify-start ">
        <p class="text-gray-400 text-sm">Rekap Nilai Polres/</p>
        <span class="font-bold text-gray-900 dark:text-gray-300 text-sm"><?= $title ?></span>
    </div>
    <div class="w-full grid grid-cols-1 md:grid-cols-3 gap-5 mt-10">
        <a href="<?= base_url("/polres/data-anggota") ?>"
            class="w-full bg-white dark:bg-gray-800 rounded-md p-5 shadow-md flex justify-between items-center hover:bg-gray-200">
            <div class="w-full flex flex-col ">
                <p class="text-gray-900 dark:text-gray-200 dark:hover:text-gray-900 text-lg font-semibold">Data Anggota</p>
                <div class="flex items-center gap-4">
                    <span class="text-gray-400 dark:hover:text-gray-900 text-lg">Total Anggota</span>
                    <span class="font-bold text-gray-900 dark:text-gray-300 dark:hover:text-gray-900 text-xl"><?= $totalAnggota ?></span>
                </div>
            </div>
            <div class="text-blue-500 rounded-full flex justify-center items-center">
                <i class="fa fa-users text-4xl"></i>
            </div>
        </a>
        <a href="<?= base_url("/polres/kelola-akun") ?>"
            class="w-full bg-white dark:bg-gray-800 rounded-md p-5 shadow-md flex justify-between items-center hover:bg-gray-200">
            <div class="w-full flex flex-col ">

                <p class="text-gray-900 dark:text-gray-200 dark:hover:text-gray-900 text-lg font-semibold">Data User Akun</p>
                <div class="flex items-center gap-4">
                    <span class="text-gray-400 dark:hover:text-gray-900 text-lg">Total User</span>
                    <span class="font-bold text-gray-900 dark:text-gray-300 dark:hover:text-gray-900 text-xl"><?= $totalUser ?></span>
                </div>
            </div>
            <div class="text-green-500 rounded-full flex justify-center items-center">
                <i class="fa fa-user text-4xl"></i>
            </div>
        </a>
        <a href="<?= base_url("/polres/filter-laporan") ?>"
            class="w-full bg-white dark:bg-gray-800 rounded-md p-5 shadow-md flex justify-between items-center hover:bg-gray-200">
            <div class="w-full flex flex-col ">
                <p class="text-gray-900 dark:text-gray-200 dark:hover:text-gray-900 text-lg font-semibold">Cetak Rekap Nilai</p>
                <div class="flex items-center gap-4">
                    <span class="text-gray-400 dark:hover:text-gray-900 text-sm">cetak rekap nilai e-mental dan e-rohani.</span>
                </div>
            </div>
            <div class="text-red-500 rounded-full flex justify-center items-center">
                <i class="fa-solid fa-file  text-4xl"></i>
            </div>
        </a>
    </div>

</div>


<?= $this->endSection() ?>