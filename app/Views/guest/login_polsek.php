<?php
/**
 * @var CodeIgniter\View\View $this
*/
?>
<?= $this->extend("/guest/layout/index") ?>
<?= $this->section("content") ?>

<body class="bg-gray-50 dark:bg-gray-600">
    <div class="xl:mx-72 lg:mx-64 md:mx-32 sm:mx-20 mx-10 mt-10">
        <div class="flex justify-center mb-5">
            <img src="<?= base_url('/img/Lambang_Polda_Jateng.png') ?>" alt="Logo" width="100px"
                onclick="history.back()" class="cursor-pointer" />
        </div>
        <form action="<?= base_url("/login") ?>" method="post" enctype="multipart/form-data"
            class="flex flex-col pb-12 bg-white dark:bg-gray-800 dark:text-gray-200 rounded-lg">
            <?= csrf_field() ?>
            <input type="hidden" name="destiny" value="satuan fungsi">
            <div class="flex justify-center">
                <h1 class="font-extrabold text-3xl mt-5 mb-16">Login Polsek/Satuan Fungsi</h1>
            </div>
            <div class="flex flex-col xl:mx-52 lg:mx-32 mx-20">
                <label for="username" class="font-extrabold mb-2">username :</label>
                <input type="text" name="username" value="<?= old('username') ?>" placeholder="username"
                    class="p-2 rounded-lg focus:ring-black bg-gray-100 dark:bg-gray-600 dark:border-gray-500 dark:text-white" />
            </div>
            <div class="flex flex-col xl:mx-52 lg:mx-32 mx-20 mt-3">
                <label for="password" class="font-extrabold mb-2">password :</label>
                <input type="password" name="password" value="<?= old('password') ?>" placeholder="password"
                    class="p-2 rounded-lg focus:ring-black bg-gray-100 dark:bg-gray-600 dark:border-gray-500 dark:text-white" />
            </div>
            <div class="flex items-center xl:mx-52 lg:mx-32 mx-20 mt-8">
                <button type="submit" class="p-2 rounded-lg text-white font-bold px-6 bg-gray-900">
                    Login
                </button>
                <a href="<?= base_url('/lupa-password') ?>" class="ml-5 text-blue-700 dark:text-gray-200 font-bold">Lupa
                    password ?</a>
            </div>
        </form>
    </div>

    <script>
    // alert error 
    <?php if (!empty(session()->getFlashdata("error_login"))) : ?>
    document.addEventListener("DOMContentLoaded", () => {
        Swal.fire({
            title: "error!",
            icon: "error",
            html: `<?= session('error_login') ?>`
        });
    })
    <?php endif; ?>
    </script>
    <?= $this->endSection() ?>