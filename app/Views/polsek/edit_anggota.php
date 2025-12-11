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
            <h2 class="mb-5 text-gray-900 dark:text-gray-200 font-bold text-xl text-center">Edit Anggota
                '<?= $anggota['name'] ?>'
            </h2>
            <form action="<?= base_url('/polsek/edit-anggota/'. $anggota['anggota_id']) ?>" method="post"
                enctype="multipart/form-data">
                <label for="name" class="my-2 text-sm font-light text-gray-500 dark:text-gray-200">Nama panjang</label>
                <input type="text" class="w-full px-6 py-3 mb-2 border border-slate-600 rounded-lg font-medium dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                    value="<?= $anggota['name'] ?>" name="name" id="name" />
                <label for="nrp" class="my-2 text-sm font-light text-gray-500 dark:text-gray-200">NRP</label>
                <input type="text" class="w-full px-6 py-3 mb-2 border border-slate-600 rounded-lg font-medium dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                    value="<?= $anggota['nrp'] ?>" name="nrp" id="nrp" />
                <label for="pangkat_id" class="my-2 text-sm font-light text-gray-500 dark:text-gray-200">Pangkat</label>
                <select type="text" class="w-full px-6 py-3 mb-2 border border-slate-600 rounded-lg font-medium dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                    name="pangkat_id" id="pangkat_id">
                    <?php foreach($pangkat as $key => $value) : ?>
                    <option value="<?= $value['pangkat_id'] ?>"
                        <?= $anggota['pangkat_id'] == $value['pangkat_id'] ? 'selected' : '' ?>><?= $value['name'] ?>
                    </option>
                    <?php endforeach; ?>
                </select>
                <label for="jabatan" class="my-2 text-sm font-light text-gray-500 dark:text-gray-200">Jabatan</label>
                <input type="text" class="w-full px-6 py-3 mb-2 border border-slate-600 rounded-lg font-medium dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                    value="<?= $anggota['jabatan'] ?>" name="jabatan" id="jabatan" />
                <button type="submit"
                    class="bg-slate-500 dark:bg-slate-600 hover:bg-slate-700 text-white text-base rounded-lg py-2.5 px-5 transition-colors w-full text-[19px] mt-5">Simpan</button>
            </form>
            <p class="text-center dark:text-gray-200 mt-3 text-[14px]">Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                Laudantium, deleniti!
            </p>
        </div>
    </div>
</div>

<script>
// alert success 
<?php if (!empty(session()->getFlashdata("success_edit_anggota"))) : ?>
document.addEventListener("DOMContentLoaded", () => {
    Swal.fire({
        title: "success!",
        icon: "success",
        html: `<?= session('success_edit_anggota') ?>`
    });
})
<?php endif; ?>
// alert error 
<?php if (!empty(session()->getFlashdata("error_edit_anggota"))) : ?>
document.addEventListener("DOMContentLoaded", () => {
    Swal.fire({
        title: "error!",
        icon: "error",
        html: `<?= session('error_edit_anggota') ?>`
    });
})
<?php endif; ?>
</script>

<?= $this->endSection() ?>