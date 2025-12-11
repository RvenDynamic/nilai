<?php
/**
 * @var CodeIgniter\View\View $this
*/
?>
<?= $this->extend("/polres/layout/index") ?>
<?= $this->section("content") ?>

<div class="w-full min-h-screen flex justify-center items-center mt-10">
    <div class="bg-white dark:bg-gray-800 rounded-md p-5 shadow-md">
        <form action="<?= base_url('/polres/laporan') ?>" method="get"
            class="w-full flex flex-col justify-center gap-5">
            <h1 class="font-bold dark:text-gray-200 text-xl">Filter Cetak Laporan</h1>
            <hr class="w-full border-t-2 border-gray-500">
            <div class="w-full flex flex-col dark:text-gray-200 gap-2">
                <label for="tahun">Tahun</label>
                <select id="tahun" name="tahun" class="w-full dark:bg-gray-600 dark:border-gray-500 dark:text-white rounded-md py-2 px-5 border border-black text-gray-900">
                    <?php foreach($years as $key => $value) : ?>
                    <option value="<?= $value ?>" <?= $value == date('Y') ? 'selected' : '' ?>><?= $value ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="w-full flex flex-col dark:text-gray-200 gap-2">
                <label for="semester">Semester</label>
                <select id="semester" name="semester"
                    class="w-full rounded-md py-2 px-5 border border-black dark:bg-gray-600 dark:border-gray-500 dark:text-white text-gray-900">
                    <option value="" selected>Semester</option>
                    <option value="Ganjil">Ganjil</option>
                    <option value="Genap">Genap</option>
                </select>
            </div>
            <div class="w-full flex dark:text-gray-200 flex-col gap-2">
                <label for="satfung">Polsek/Satfung</label>
                <select id="satfung" name="satfung"
                    class="w-full rounded-md py-2 px-5 border border-black dark:bg-gray-600 dark:border-gray-500 dark:text-white text-gray-900">
                    <option value="" selected>polsek/satfung</option>
                    <?php foreach($satfung as $key => $value) : ?>
                    <option value="<?= $value['satfung_id'] ?>"><?= $value['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="w-full flex flex-col dark:text-gray-200 gap-2">
                <label for="mapel">Pilih Nilai</label>
                <select id="mapel" name="mapel" class="w-full rounded-md py-2 px-5 border border-black text-gray-900 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                    <option value="" selected>Nilai</option>
                    <option value="mental">Mental</option>
                    <option value="rohani">Rohani</option>
                </select>
            </div>
            <button
                class="bg-green-500 text-white p-3 shadow-md rounded-md hover:bg-white hover:text-green-500 hover:shadow-green-400 font-bold">Filter</button>
        </form>
    </div>
</div>


<script>
// alert error 
<?php if (!empty(session()->getFlashdata("error_filter"))) : ?>
document.addEventListener("DOMContentLoaded", () => {
    Swal.fire({
        title: "error!",
        icon: "error",
        html: `<?= session('error_filter') ?>`
    });
})
<?php endif; ?>
</script>

<?= $this->endSection() ?>