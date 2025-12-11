<?php
/**
 * @var CodeIgniter\View\View $this
*/
?>
<?= $this->extend("/polsek/layout/index") ?>
<?= $this->section("content") ?>

<div class="container mx-auto mt-20 p-5">
    <div class="w-full flex  gap-1 justify-start ">
        <p class="text-gray-400 text-sm">Rekap Nilai Polsek/</p>
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
                        class="w-full py-2 px-5 text-sm text-gray-900 border border-black rounded-l-full bg-white focus:outline-none dark:bg-gray-700 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-black dark:focus:border-black"
                        placeholder="Cari nama anggota..." />
                    <button onclick="search()" class="py-2 px-3 bg-slate-900 rounded-r-full text-white"><i
                            class="fa-solid fa-magnifying-glass"></i></button>
                </div>
                <div class="w-full flex items-center">
                    <select onchange="filterPangkat(this)" name="filter"
                        class="w-full rounded-full py-2 px-5 border border-black text-gray-900 dark:bg-gray-700 dark:border-gray-500 dark:text-gray-400">
                        <option value="" selected>filter pangkat</option>
                        <option value="semua">semua pangkat</option>
                        <?php foreach($pangkat as $key => $value) : ?>
                        <?php $isActive = isset($_GET['pangkat']) && $_GET['pangkat'] == $value['pangkat_id']; ?>
                        <option value="<?= $value['pangkat_id'] ?>" <?= $isActive ? 'selected' : '' ?>>
                            <?= $value['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <button type="button" data-modal-target="tambah-modal" data-modal-toggle="tambah-modal"
                class="flex justify-center items-center gap-2 text-green-600 hover:font-bold border text-sm border-green-600 rounded-full font-bold px-2 py-1 hover:bg-green-500 hover:border-green-800 hover:text-white mr-6 lg:mr-16">
                <i class="fa-solid fa-user-plus"></i>
                <span class="hidden md:block">
                    Tambah Anggota
                </span>
            </button>
        </div>
        <!-- tabel -->
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5">
            <table class="w-full text-sm text-start md:text-center rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">No</th>
                        <th scope="col" class="px-6 py-3">Nama</th>
                        <th scope="col" class="px-6 py-3">Pangkat</th>
                        <th scope="col" class="px-6 py-3">Jabatan</th>
                        <th scope="col" class="px-6 py-3">NRP/NIP</th>
                        <th scope="col" class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($anggota)) : ?>
                    <?php if(isset($_GET['search'])) : ?>
                    <td class="px-6 py-4 font-bold text-2xl" colspan="6">Hasil cari "<?= $_GET['search'] ?> tidak ada"
                    </td>
                    <?php else : ?>
                    <td class="px-6 py-4 font-bold text-2xl" colspan="6">Data anggota kosong</td>
                    <?php  endif; ?>
                    <?php else : ?>
                    <?php $no = 1 ?>
                    <?php foreach($anggota as $key => $value) : ?>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4"><?= $no ?></td>
                        <td class="px-6 py-4"><?= $value['name'] ?></td>
                        <td class="px-6 py-4"><?= $value['pangkat_name'] ?></td>
                        <td class="px-6 py-4"><?= $value['jabatan'] ?></td>
                        <td class="px-6 py-4"><?= $value['nrp'] ?></td>
                        <td class="px-6 py-4 flex justify-end items-center gap-1">
                            <a href="<?= base_url("polsek/cek-nilai/". $value['anggota_id'])  ?>"
                                class="flex justify-center items-center gap-2 text-indigo-600 hover:font-bold border text-xs border-indigo-600 rounded-full font-bold px-2 py-1 hover:bg-indigo-500 hover:border-indigo-800 hover:text-white">
                                <i class="fa-solid fa-list-check"></i>
                                <span class="hidden md:block">
                                    Cek Nilai
                                </span>
                            </a>
                            <a href="<?= base_url("polsek/edit-anggota/". $value['anggota_id'])?>"
                                class="flex justify-center items-center gap-2 text-indigo-600 hover:font-bold border text-xs border-indigo-600 rounded-full font-bold px-2 py-1 hover:bg-indigo-500 hover:border-indigo-800 hover:text-white">
                                <i class="fa-solid fa-pen-to-square"></i>
                                <span class="hidden md:block">
                                    Edit
                                </span>
                            </a>
                            <button
                                onclick="deleteAnggota('<?= base_url('/polsek/delete-anggota/'. $value['anggota_id']) ?>')"
                                href="#"
                                class="flex justify-center items-center gap-2 text-red-600 hover:font-bold border text-xs border-red-600 rounded-full font-bold px-2 py-1 hover:bg-red-500 hover:border-red-800 hover:text-white">
                                <i class="fa-solid fa-trash"></i>
                                <span class="hidden md:block">
                                    Delete
                                </span>
                            </button>
                        </td>
                    </tr>
                    <?php $no++ ?>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <!-- /tabel -->
    </div>
</div>

<!-- tambah modal -->
<div id="tambah-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Tambah Anggota
                </h3>
                <button type="button"
                    class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="tambah-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Kembali</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5">

                <form action="<?= base_url('/polsek/tambah-anggota') ?>" method="post" enctype="multipart/form-data">
                    <div class="mb-6">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                            Panjang</label>
                        <input type="text" id="name" name="name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required />
                    </div>
                    <div class="mb-6">
                        <label for="jabatan"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jabatan</label>
                        <input type="text" id="jabatan" name="jabatan"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required />
                    </div>
                    <div class="mb-6">
                        <label for="pangkat_id"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pangkat</label>
                        <select id="pangkat_id" name="pangkat_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required>
                            <option selected>pilih Pangkat</option>
                            <?php foreach($pangkat as $key => $value) : ?>
                            <option value="<?= $value['pangkat_id'] ?>"><?= $value['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-6">
                        <label for="nrp"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NRP/NIP</label>
                        <input type="number" id="nrp" name="nrp"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required />
                    </div>
                    <div class="border-t pt-4 flex justify-end">
                        <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Simpan</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<script>
// function
const deleteAnggota = (url) => {
    Swal.fire({
        title: "Apakah anda yakin?",
        text: "Anggota yang dihapus tidak dapat dikembalikan",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, Hapus",
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url
        }
    })
}


// filter 
const filterPangkat = (pangkat) => {
    pangkatId = pangkat.value

    if (pangkatId != "semua") {
        window.location.href = `<?= base_url('/polsek/data-anggota?pangkat='); ?>${pangkatId}`
    } else {
        window.location.href = `<?= base_url('/polsek/data-anggota?pangkat='); ?>`
    }
}

//search
let searchValue = document.getElementById('search')

searchValue.addEventListener('keypress', (e) => {
    if (!searchValue.value) return
    if (e.key === 'Enter') {
        window.location.href = `<?= base_url('/polsek/data-anggota?search='); ?>${searchValue.value}`
    }
})

const search = () => {
    if (!searchValue.value) return
    window.location.href = `<?= base_url('/polsek/data-anggota?search='); ?>${searchValue.value}`
}

// alert success 
<?php if (!empty(session()->getFlashdata("success_tambah_anggota"))) : ?>
document.addEventListener("DOMContentLoaded", () => {
    Swal.fire({
        title: "success!",
        icon: "success",
        html: `<?= session('success_tambah_anggota') ?>`
    });
})
<?php endif; ?>

<?php if (!empty(session()->getFlashdata("success_delete_anggota"))) : ?>
document.addEventListener("DOMContentLoaded", () => {
    Swal.fire({
        title: "success!",
        icon: "success",
        html: `<?= session('success_delete_anggota') ?>`
    });
})
<?php endif; ?>

// alert error 
<?php if (!empty(session()->getFlashdata("error_tambah_anggota"))) : ?>
document.addEventListener("DOMContentLoaded", () => {
    Swal.fire({
        title: "error!",
        icon: "error",
        html: `<?= session('error_tambah_anggota') ?>`
    });
})
<?php endif; ?>

<?php if (!empty(session()->getFlashdata("error_delete_anggota"))) : ?>
document.addEventListener("DOMContentLoaded", () => {
    Swal.fire({
        title: "error!",
        icon: "error",
        html: `<?= session('error_delete_anggota') ?>`
    });
})
<?php endif; ?>
</script>

<?= $this->endSection() ?>