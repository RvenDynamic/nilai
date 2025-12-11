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
    <div class="flex justify-between mb-5 dark:text-gray-200 font-extrabold text-2xl mx-auto items-center">
        <h1 class="">Kelola Akun</h1>
        <img src="<?= base_url('/img/Lambang_Polda_Jateng.png') ?>" alt="Logo" width="60px" />
    </div>
    <div class="flex flex-col mb-5 bg-white dark:bg-gray-800 rounded-lg">
        <div class="w-full flex justify-end items-center gap-2 md:gap-5 my-5">
            <!-- Modal button register -->
            <button data-modal-target="register-modal" data-modal-toggle="register-modal" type="button"
                class="px-2 py-1 border border-green-500 text-green-500 font-semibold rounded-md hover:bg-green-500 hover:text-white dark:text-gray-400 dark:border-gray-400 dark:hover:bg-gray-400 dark:hover:border-gray-300 dark:hover:text-gray-300 mr-5">Register</button>
        </div>
        <!-- tabel -->
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5">
            <table class="w-full text-sm text-start md:text-center rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">No</th>
                        <th scope="col" class="px-6 py-3">Username</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Polsek/Satfung</th>
                        <th scope="col" class="px-6 py-3">Role</th>
                        <th scope="col" class="px-6 py-3">Active</th>
                        <th scope="col" class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1 ?>
                    <?php foreach($users as $key => $value) : ?>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4"><?= $no ?></td>
                        <td class="px-6 py-4"><?= $value['username'] ?></td>
                        <td class="px-6 py-4"><?= $value['email'] ?></td>
                        <td class="px-6 py-4"><?= $value['satfung'] ?></td>
                        <td class="px-6 py-4">
                            <?= $value['role'] === "satuan fungsi" ? "polsek/satuan fungsi" : $value['role'] ?></td>
                        <td class="px-6 py-4">
                            <span
                                class="px-2 py-1 text-xs font-semibold leading-5 <?= $value['is_verified'] ? 'text-green-800 bg-green-100' : 'text-red-800 bg-red-100'  ?> rounded-full">
                                <?= $value['is_verified'] ? 'active' : 'non-active' ?>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <button
                                onclick="deleteAkun('<?= base_url('/polres/delete-account/'. $value['user_id']); ?>')"
                                type="button"
                                class="flex justify-center items-center gap-2 text-red-600 hover:font-bold border text-xs border-red-600 rounded-full font-bold px-2 py-1 hover:bg-red-500 hover:border-red-800 hover:text-white">
                                <i class="fa-solid fa-trash"></i>
                                <span class="hidden md:block">
                                    Hapus
                                </span>
                            </button>
                        </td>
                    </tr>
                    <?php $no++ ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- /tabel -->
    </div>
</div>

<!-- register modal -->
<div id="register-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Register akun baru
                </h3>
                <button type="button"
                    class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="register-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <form class="space-y-4" action="<?= base_url("polres/register") ?>" method="post"
                    enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div>
                        <label for="username"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">username</label>
                        <input type="text" name="username" id="username"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            placeholder="polres pekalongan" required />
                    </div>
                    <div>
                        <label for="email"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">email</label>
                        <input type="email" name="email" id="email"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            placeholder="polres@email.com" required />
                    </div>
                    <div>
                        <label for="role_id"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">role</label>
                        <select id="role_id" name="role_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required>
                            <option selected>pilih role user</option>
                            <?php foreach($role as $key => $value) : ?>
                            <option value="<?= $value['role_id'] ?>">
                                <?= $value['name'] === "satuan fungsi" ? "polsek/satuan fungsi" : $value['name'] ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="satfung_id"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sektor /
                            Satfung</label>
                        <select id="satfung_id" name="satfung_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required>
                            <option selected>pilih sektor/satfung user</option>
                            <?php foreach($satfung as $key => $value) : ?>
                            <option value="<?= $value['satfung_id'] ?>"><?= $value['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="password"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">password</label>
                        <input type="password" name="password" placeholder="••••••••"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            required />
                    </div>
                    <div>
                        <label for="password_conf"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">masukan password
                            lagi</label>
                        <input type="password" name="password_conf" placeholder="••••••••"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            required />
                    </div>
                    <button type="submit"
                        class="w-full text-white bg-green-500 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Login
                        to your account</button>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
const deleteAkun = (url) => {
    Swal.fire({
        title: "Apakah anda yakin?",
        text: "Akun yang dihapus tidak dapat dikembalikan",
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

// alert success 
<?php if (session()->has('success_register')) : ?>
document.addEventListener("DOMContentLoaded", () => {
    Swal.fire({
        title: "success!",
        text: "<?= session('success_register') ?>",
        icon: "success"
    });
})
<?php endif; ?>

// alert error 
<?php if (!empty(session()->getFlashdata("error_register"))) : ?>
document.addEventListener("DOMContentLoaded", () => {
    Swal.fire({
        title: "error!",
        icon: "error",
        html: `<?= session('error_register') ?>`
    });
})
<?php endif; ?>
</script>
<?= $this->endSection() ?>