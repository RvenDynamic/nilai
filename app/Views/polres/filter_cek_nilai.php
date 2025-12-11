<?php
/**
 * @var CodeIgniter\View\View $this
*/
?>
<?= $this->extend("/polres/layout/index") ?>
<?= $this->section("content") ?>

<div class="container  mx-auto mt-20 p-5 ">
    <div class="flex justify-center items-center">
        <div class="bg-white dark:bg-gray-800 p-10 rounded-md shadow-md flex flex-col items-center gap-3 mt-20">
            <h1 class="text-2xl dark:text-gray-200 font-bold">"<?= $name ?>"</h1>
            <div class="w-full flex flex-col gap-4">
                <p class="text-center dark:text-gray-200 font-semibold">Filter nilai</p>
                <select id="tahun" name="tahun" class="w-full rounded-full py-2 px-5 border border-black text-gray-900 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                    <option value="" selected>Tahun</option>
                    <?php foreach($years as $key => $value) : ?>
                    <option value="<?= $value ?>"><?= $value ?></option>
                    <?php endforeach; ?>
                </select>
                <select id="semester" name="semester"
                    class="w-full rounded-full py-2 px-5 border border-black text-gray-900 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                    <option value="" selected>Semester</option>
                    <option value="Ganjil">Ganjil</option>
                    <option value="Genap">Genap</option>
                </select>
                <p class="text-center dark:text-gray-200 font-semibold">Pilih nilai</p>
                <div class="w-full flex gap-3 items-center justify-center">
                    <button onclick="mental()"
                        class="p-2 border border-fuchsia-500 font-semibold text-lg rounded-md text-fuchsia-500 hover:bg-fuchsia-500 hover:text-white">E-Mental</button>
                    <button onclick="rohani()"
                        class="p-2 border border-indigo-500 font-semibold text-lg rounded-md text-indigo-500 hover:bg-indigo-500 hover:text-white">E-Rohani</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
const tahun = document.getElementById('tahun')
const semester = document.getElementById('semester')

const mental = () => {
    if (tahun.value && semester.value) {
        window.location.href =
            `<?= base_url('/polres/edit-nilai/'. $anggota_id) ?>?mapel=mental&tahun=${tahun.value}&semester=${semester.value}`
    } else if (tahun.value) {
        window.location.href =
            `<?= base_url('/polres/edit-nilai/'. $anggota_id) ?>?mapel=mental&tahun=${tahun.value}`
    } else if (semester.value) {
        window.location.href =
            `<?= base_url('/polres/edit-nilai/'. $anggota_id) ?>?mapel=mental&semester=${semester.value}`
    } else {
        window.location.href = `<?= base_url('/polres/edit-nilai/'. $anggota_id) ?>?mapel=mental`
    }
}

const rohani = () => {
    if (tahun.value && semester.value) {
        window.location.href =
            `<?= base_url('/polres/edit-nilai/'. $anggota_id) ?>?mapel=rohani&tahun=${tahun.value}&semester=${semester.value}`
    } else if (tahun.value) {
        window.location.href =
            `<?= base_url('/polres/edit-nilai/'. $anggota_id) ?>?mapel=rohani&tahun=${tahun.value}`
    } else if (semester.value) {
        window.location.href =
            `<?= base_url('/polres/edit-nilai/'. $anggota_id) ?>?mapel=rohani&semester=${semester.value}`
    } else {
        window.location.href = `<?= base_url('/polres/edit-nilai/'. $anggota_id) ?>?mapel=rohani`
    }
}
</script>

<?= $this->endSection() ?>