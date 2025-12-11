<?php
/**
 * @var CodeIgniter\View\View $this
*/
?>
<?= $this->extend("/polsek/layout/index") ?>
<?= $this->section("content") ?>

<div class="container mx-auto mt-20 p-2">
    <div class="flex justify-between mb-5 ml-3 md:ml-0 font-extrabold text-xl items-center">
        <a href="<?= base_url("/polsek/data-anggota") ?>" class="hover:underline dark:text-gray-200"><i
                class="fa-solid fa-arrow-left-long mr-5"></i>Kembali</a>
        <img src="<?= base_url('/img/Lambang_Polda_Jateng.png') ?>" alt="Logo" width="60px" />
    </div>
    <div class="flex flex-col mb-5 pb-5 bg-white dark:bg-gray-800 dark:text-gray-200 rounded-lg">
        <div class="flex justify-between ml-5 mr-14 mt-10">
            <h1 class="font-bold ml-10">Nilai E-Mental & E-Rohani "<?= $anggota['name'] ?>"</h1>

        </div>
        <div class="ml-5 mt-10 grid grid-flow-col justify-left">
            <label class="ml-10 font-bold" for="nama">Nama : <span
                    class="font-normal"><?= $anggota['name'] ?></span></label>
            <label class="font-bold" for="nrp">NRP/NIP : <span class="font-normal"><?= $anggota['nrp'] ?></span></label>
        </div>
        <div class="ml-5 mt-8 grid grid-flow-col justify-left">
            <label class="ml-10 font-bold" for="jabatan">Jabatan : <span
                    class="font-normal"><?= $anggota['jabatan'] ?></span></label>
            <label class="mr-8 font-bold" for="pangkat">Pangkat : <span
                    class="font-normal"><?= $anggota['pangkat_name'] ?></span></label>
        </div>

    </div>
    <div class="my-2 flex justify-end">
        <select onchange="filterSemester(this)" name="semester"
            class="max-w-md  rounded-full py-2 px-5 border border-black text-gray-900 dark:bg-gray-800 dark:border-gray-500 dark:text-gray-400">
            <option value="" selected>filter semester</option>
            <option value="" <?= isset($_GET['semester']) && $_GET['semester'] === "" ? 'selected' :'' ?>>Semua</option>
            <option value="Ganjil" <?= isset($_GET['semester']) && $_GET['semester'] === "Ganjil" ? 'selected' :'' ?>>
                Ganjil</option>
            <option value="Genap" <?= isset($_GET['semester']) && $_GET['semester'] === "Genap" ? 'selected' :'' ?>>
                Genap</option>
        </select>
    </div>
    <div class="w-full flex flex-col md:flex-row gap-2 mt-3">
        <!-- tabel mental -->
        <div class="w-full relative overflow-x-auto sm:rounded-lg mt-5 bg-white dark:bg-gray-800 shadow-md rounded-md">
            <div class="w-full px-4 my-2 flex justify-between items-center">
                <h1 class="font-bold text-slate-900 dark:text-gray-200">Input Nilai E-Mental</h1>
                <button data-modal-target="mental-modal" data-modal-toggle="mental-modal"
                    class="flex justify-center items-center gap-2 font-bold text-green-600 text-lg hover:font-bold border border-green-600 rounded-full text-center p-3 hover:bg-green-500 hover:border-green-800 hover:text-white">
                    <i class="fa-solid fa-plus "></i>
                </button>
            </div>
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
                    <?php if(empty($mental)) : ?>
                    <td class="px-6 py-4 font-bold text-xl text-center" colspan="4">Data nilai kosong</td>
                    <?php else : ?>
                    <?php foreach($mental as $key => $value) : ?>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-16 py-4"><?= $value['tahun'] ?></td>
                        <td class="px-16 py-4">
                            <span
                                class="p-2 ring-1  <?= $value['semester'] === 'Genap' ? "ring-fuchsia-500 text-fuchsia-500" : 'ring-indigo-500 text-indigo-500' ?> font-semibold rounded-full">
                                <?= $value['semester'] ?>
                            </span>
                        </td>
                        <td class="px-16 py-4 font-bold"><?= $value['nilai'] ?></td>
                        <td class="flex  pr-2 py-4 gap-2 items-center">
                            <button data-modal-target="bukti-modal-mental-<?= $value['mental_id'] ?>"
                                data-modal-toggle="bukti-modal-mental-<?= $value['mental_id'] ?>"
                                class="flex justify-center items-center gap-2 font-bold text-blue-600 hover:font-bold border border-blue-600 rounded-full text-center px-3 py-0.5 hover:bg-blue-500 hover:border-blue-800 hover:text-white">
                                <i class="fa-solid fa-image"></i>
                            </button>
                            <a href="<?= base_url('/polsek/edit-nilai/'. $value['mental_id']) ?>?mapel=mental"
                                class="flex justify-center items-center gap-2 font-bold text-green-600 hover:font-bold border border-green-600 rounded-full text-center px-3 py-0.5 hover:bg-green-500 hover:border-green-800 hover:text-white">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <button onclick="deleteNilai1('<?= $value['mental_id'] ?>')"
                                class="flex justify-center items-center gap-2 font-bold text-red-600 hover:font-bold border border-red-600 rounded-full text-center px-3 py-0.5 hover:bg-red-500 hover:border-red-800 hover:text-white">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- bukti nilai emental modal -->
                    <div id="bukti-modal-mental-<?= $value['mental_id'] ?>" tabindex="-1"
                        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative w-full max-w-4xl max-h-full">
                            <!-- Modal content -->
                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                <!-- Modal header -->
                                <div
                                    class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                                        Bukti Nilai E-Mental
                                    </h3>
                                    <button type="button"
                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                        data-modal-hide="bukti-modal-mental-<?= $value['mental_id'] ?>">
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
                    <?php endif; ?>

                </tbody>
            </table>
        </div>
        <!-- /tabel -->
        <!-- tabel mental -->
        <div class="w-full relative overflow-x-auto sm:rounded-lg mt-5 bg-white dark:bg-gray-800 shadow-md rounded-md">
            <div class="w-full px-4 my-2 flex justify-between items-center">
                <h1 class="font-bold text-slate-900 dark:text-gray-200">Input Nilai E-Rohani</h1>
                <button data-modal-target="rohani-modal" data-modal-toggle="rohani-modal"
                    class="flex justify-center items-center gap-2 font-bold text-green-600 text-lg hover:font-bold border border-green-600 rounded-full text-center p-3 hover:bg-green-500 hover:border-green-800 hover:text-white">
                    <i class="fa-solid fa-plus "></i>
                </button>
            </div>
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
                    <?php if(empty($rohani)) : ?>
                    <td class="px-6 py-4 font-bold text-xl text-center" colspan="4">Data nilai kosong</td>
                    <?php else : ?>
                    <?php foreach($rohani as $key => $value) : ?>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-16 py-4"><?= $value['tahun'] ?></td>
                        <td class="px-16 py-4">
                            <span
                                class="p-2 ring-1  <?= $value['semester'] === 'Genap' ? "ring-fuchsia-500 text-fuchsia-500" : 'ring-indigo-500 text-indigo-500' ?> font-semibold rounded-full">
                                <?= $value['semester'] ?>
                            </span>
                        </td>
                        <td class="px-16 py-4 font-bold"><?= $value['nilai'] ?></td>
                        <td class="flex items-center pr-2 gap-2 py-4">
                            <button data-modal-target="bukti-modal-rohani-<?= $value['rohani_id'] ?>"
                                data-modal-toggle="bukti-modal-rohani-<?= $value['rohani_id'] ?>"
                                class="flex justify-center items-center gap-2 font-bold text-blue-600 hover:font-bold border border-blue-600 rounded-full text-center px-3 py-0.5 hover:bg-blue-500 hover:border-blue-800 hover:text-white">
                                <i class="fa-solid fa-image"></i>
                            </button>
                            <a href="<?= base_url('/polsek/edit-nilai/'. $value['rohani_id']) ?>?mapel=rohani"
                                class="flex justify-center items-center gap-2 font-bold text-green-600 hover:font-bold border border-green-600 rounded-full text-center px-3 py-0.5 hover:bg-green-500 hover:border-green-800 hover:text-white">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <button onclick="deleteNilai2('<?= $value['rohani_id'] ?>')"
                                class="flex justify-center items-center gap-2 font-bold text-red-600 hover:font-bold border border-red-600 rounded-full text-center px-3 py-0.5 hover:bg-red-500 hover:border-red-800 hover:text-white">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- bukti nilai emental modal -->
                    <div id="bukti-modal-rohani-<?= $value['rohani_id'] ?>" tabindex="-1"
                        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative w-full max-w-4xl max-h-full">
                            <!-- Modal content -->
                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                <!-- Modal header -->
                                <div
                                    class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                                        Bukti Nilai E-Mental
                                    </h3>
                                    <button type="button"
                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                        data-modal-hide="bukti-modal-rohani-<?= $value['rohani_id'] ?>">
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
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <!-- /tabel -->


    </div>

</div>


<!-- mental modal -->
<div id="mental-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    input Nilai E-Mental
                </h3>
                <button type="button"
                    class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="mental-modal">
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
                <form action="<?= base_url('/polsek/tambah-nilai/mental') ?>" method="post"
                    enctype="multipart/form-data">
                    <input type="hidden" value="<?= $anggota['anggota_id'] ?>" name="anggota_id">
                    <div class="mb-6">
                        <label for="tahun"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tahun</label>
                        <select id="tahun" name="tahun"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required>
                            <?php foreach($years as $key => $value) : ?>
                            <option value="<?= $value ?>" <?= $value == date("Y") ? 'selected' : '' ?>><?= $value ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="semester"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Semester</label>
                            <select id="semester" name="semester" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700
                                dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500
                                dark:focus:border-blue-500" required>
                                <option value="Ganjil" selected>Ganjil</option>
                                <option value="Genap">Genap</option>
                            </select>
                        </div>
                        <div>
                            <label for="nilai"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nilai</label>
                            <input type="number" step="0.01" id="nilai" name="nilai"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required />
                        </div>
                    </div>
                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="bukti">Upload
                            Bukti</label>
                        <input
                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                            onchange="readPriview(this)" accept=".png, .jpg, .jpeg" id="bukti" name="bukti" type="file">

                    </div>
                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            for="file_input">Preview :</label>
                        <img src="<?= base_url("img/default.png") ?>" class="w-full rounded-sm" alt="priview"
                            id="priview">

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

<!-- rohani modal -->
<div id="rohani-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    input Nilai E-Rohani
                </h3>
                <button type="button"
                    class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="rohani-modal">
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
                <form action="<?= base_url('/polsek/tambah-nilai/rohani') ?>" method="post"
                    enctype="multipart/form-data">
                    <input type="hidden" value="<?= $anggota['anggota_id'] ?>" name="anggota_id">
                    <div class="mb-6">
                        <label for="tahun"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tahun</label>
                        <select id="tahun" name="tahun"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required>
                            <?php foreach($years as $key => $value) : ?>
                            <option value="<?= $value ?>" <?= $value == date("Y") ? 'selected' : '' ?>><?= $value ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="semester"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Semester</label>
                            <select id="semester" name="semester" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700
                                dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500
                                dark:focus:border-blue-500" required>
                                <option value="Ganjil" selected>Ganjil</option>
                                <option value="Genap">Genap</option>
                            </select>
                        </div>
                        <div>
                            <label for="nilai"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nilai</label>
                            <input type="number" step="0.01" id="nilai" name="nilai"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required />
                        </div>
                    </div>
                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="bukti">Upload
                            Bukti</label>
                        <input
                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                            onchange="readPriview2(this)" accept=".png, .jpg, .jpeg" id="bukti" name="bukti"
                            type="file">

                    </div>
                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            for="file_input">Preview :</label>
                        <img src="<?= base_url("img/default.png") ?>" class="w-full rounded-sm" alt="priview"
                            id="priview2">

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
const deleteNilai1 = (id) => {
    Swal.fire({
        title: "Apakah anda yakin?",
        text: "nilai yang dihapus tidak dapat dikembalikan",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, Hapus",
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `<?= base_url('/polsek/delete-nilai/') ?>${id}?mapel=mental`
        }
    })
}

const deleteNilai2 = (id) => {
    Swal.fire({
        title: "Apakah anda yakin?",
        text: "nilai yang dihapus tidak dapat dikembalikan",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, Hapus",
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `<?= base_url('/polsek/delete-nilai/') ?>${id}?mapel=rohani`
        }
    })
}


const readPriview = (input) => {
    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = (e) => {
            document.getElementById('priview').src = e.target.result;
        };

        reader.readAsDataURL(input.files[0]);
    }
}

const readPriview2 = (input) => {
    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = (e) => {
            document.getElementById('priview2').src = e.target.result;
        };

        reader.readAsDataURL(input.files[0]);
    }
}

const filterSemester = (semester) => {
    semesterValue = semester.value

    if (semesterValue) {
        window.location.href =
            `<?= base_url('/polsek/cek-nilai/'. $anggota['anggota_id']. '?semester=')?>${semesterValue}`
    } else {
        window.location.href =
            `<?= base_url('/polsek/cek-nilai/'. $anggota['anggota_id']. '?semester=')?>`
    }
}

// alert success 
<?php if (!empty(session()->getFlashdata("success_tambah_nilai"))) : ?>
document.addEventListener("DOMContentLoaded", () => {
    Swal.fire({
        title: "success!",
        icon: "success",
        html: `<?= session('success_tambah_nilai') ?>`
    });
})
<?php endif; ?>

<?php if (!empty(session()->getFlashdata("success_delete_nilai"))) : ?>
document.addEventListener("DOMContentLoaded", () => {
    Swal.fire({
        title: "success!",
        icon: "success",
        html: `<?= session('success_delete_nilai') ?>`
    });
})
<?php endif; ?>

<?php if (!empty(session()->getFlashdata("success_edit_nilai"))) : ?>
document.addEventListener("DOMContentLoaded", () => {
    Swal.fire({
        title: "success!",
        icon: "success",
        html: `<?= session('success_edit_nilai') ?>`
    });
})
<?php endif; ?>

// alert error 
<?php if (!empty(session()->getFlashdata("error_delete_nilai"))) : ?>
document.addEventListener("DOMContentLoaded", () => {
    Swal.fire({
        title: "error!",
        icon: "error",
        html: `<?= session('error_delete_nilai') ?>`
    });
})
<?php endif; ?>

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