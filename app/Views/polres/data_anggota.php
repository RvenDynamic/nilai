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
    <div class="flex justify-between mb-5  font-extrabold text-2xl mx-auto items-center">
        <h1 class="dark:text-gray-200">Anggota </h1>
        <img src="<?= base_url('/img/Lambang_Polda_Jateng.png') ?>" alt="Logo" width="60px" />
    </div>
    <div class="flex flex-col mb-5 bg-white dark:bg-gray-800 dark:text-gray-200 rounded-lg">
        <div class="flex mt-5 md:mt-10 items-center">
            <h1 class="font-bold ml-7 md:ml-10">Setting</h1>
            <div class="max-w-sm md:mx-auto mx-10 flex flex-col md:flex-row gap-2">
                <div class="w-full flex items-center">
                    <input type="search" id="search"
                        class="w-full py-2  px-5 text-sm text-gray-900 border border-black rounded-l-full bg-white focus:outline-none dark:bg-gray-700 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-black dark:focus:border-black"
                        placeholder="Cari nama..." />
                    <button onclick="searchNama()" class="py-2 px-3 bg-slate-900 rounded-r-full text-white"><i
                            class="fa-solid fa-magnifying-glass"></i></button>
                </div>
                <div class="w-full flex items-center">
                    <select onchange="filterSatfung(this)" name="filter"
                        class="w-full rounded-full py-2 px-5 border border-black text-gray-900 dark:bg-gray-700 dark:border-gray-500 dark:text-gray-400">
                        <option value="" selected>Sektor/Satfung</option>
                        <option value="">semua</option>
                        <?php foreach($satfungs as $key => $value) : ?>
                        <option value="<?= $value['satfung_id'] ?>"
                            <?= isset($_GET['satfung']) && $_GET['satfung'] === $value['satfung_id'] ? 'selected' : ''  ?>>
                            <?= $value['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <!-- tabel -->
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5">
            <table class="w-full text-sm text-start md:text-center rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">No</th>
                        <th scope="col" class="px-6 py-3">Nama</th>
                        <th scope="col" class="px-6 py-3">Jabatan</th>
                        <th scope="col" class="px-6 py-3">Pangkat</th>
                        <th scope="col" class="px-6 py-3">Polsek/Satfung</th>
                        <th scope="col" class="px-6 py-3">NRP/NIP</th>
                        <th scope="col" class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($anggotas)) : ?>
                    <?php if (isset($_GET['search'])) : ?>
                    <td class="px-6 py-4 text-center font-bold text-lg" colspan="6">Pencarian "<?= $_GET['search'] ?>"
                        Ditemukan</td>
                    <?php else : ?>
                    <td class="px-6 py-4 text-center font-bold text-lg" colspan="6">Data tidak Ditemukan</td>
                    <?php endif; ?>
                    <?php else : ?>
                    <?php $no = 1 ?>
                    <?php foreach($anggotas as $key => $value) : ?>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4"><?= $no ?></td>
                        <td class="px-6 py-4"><?= $value['name'] ?></td>
                        <td class="px-6 py-4"><?= $value['jabatan'] ?></td>
                        <td class="px-6 py-4"><?= $value['pangkat_name'] ?></td>
                        <td class="px-6 py-4"><?= $value['satfung_name'] ?></td>
                        <td class="px-6 py-4"><?= $value['nrp'] ?></td>
                        <td class="px-6 py-4 flex justify-center items-center">
                            <a href="<?= base_url("polres/filter-nilai/". $value['anggota_id'])  ?>"
                                class="flex justify-center dark:border-gray-400 items-center gap-2 text-indigo-600 hover:font-bold border text-xs border-indigo-600 rounded-full font-bold px-2 py-1 hover:bg-indigo-500 hover:border-indigo-800 hover:text-white">
                                <i class="fa-solid dark:text-gray-400 fa-list-check"></i>
                                <span class="hidden md:block">
                                    Cek Nilai
                                </span>
                            </a>
                        </td>
                    </tr>
                    <?php $no++ ?>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="w-full my-3 flex justify-end px-10">
                <?= $pager->links('default', 'custom_pager') ?>
            </div>
        </div>
        <!-- /tabel -->
    </div>
</div>

<script>
// satfung
const filterSatfung = (satfung) => {
    const satfungId = satfung.value
    if (satfungId !== "") {
        window.location.href = `<?= base_url('polres/data-anggota') ?>?satfung=${satfungId}`
    } else {
        window.location.href = `<?= base_url('polres/data-anggota') ?>`
    }
}

// search
let searchValue = document.getElementById('search')

searchValue.addEventListener('keypress', (e) => {
    if (!searchValue.value) return
    if (e.key === 'Enter') {
        if (!searchValue.value) return
        window.location.href = `<?= base_url('polres/data-anggota?search=') ?>${searchValue.value}`
    }
})

const searchNama = () => {
    if (!searchValue.value) return
    window.location.href = `<?= base_url('polres/data-anggota?search=') ?>${searchValue.value}`
}
</script>


<?= $this->endSection() ?>