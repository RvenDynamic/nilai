<?php
/**
 * @var CodeIgniter\View\View $this
*/
?>
<?= $this->extend("/guest/layout/index") ?>
<?= $this->section("content") ?>

<body class="dark:bg-gray-600">
    <div class="flex justify-center items-center font-extrabold">
        <div class="mt-24">
            <h1 class="text-3xl dark:text-gray-200">Aplikasi nilai polres</h1>
            <img class="mx-auto mt-12" src="<?= base_url('/img/Lambang_Polda_Jateng.png') ?>" alt="Logo"
                width="120px" />
            <div class="flex justify-center dark:text-gray-200 mt-5">Login sebagai</div>
            <div class="flex flex-col gap-3 mt-5">
                <button id="polres" class="px-10 py-3 rounded-lg bg-gray-200 dark:bg-gray-800 dark:text-gray-200">Polres</button>
                <button id="polsek" class="px-10 py-3 rounded-lg bg-gray-200 dark:bg-gray-800 dark:text-gray-200 break-words">Polsek/Satfung</button>
            </div>
        </div>
    </div>
    <script>
    document.getElementById('polres').addEventListener('click', function() {
        window.location.href = '<?= base_url('/log-polres'); ?>'
    })

    document.getElementById('polsek').addEventListener('click', function() {
        window.location.href = '<?= base_url('/log-polsek'); ?>'
    })

    // alert success
    <?php if (!empty(session()->getFlashdata("success_forgot_password"))) : ?>
    document.addEventListener("DOMContentLoaded", () => {
        Swal.fire({
            title: "success!",
            icon: "success",
            html: `<?= session('success_forgot_password') ?>`
        });
    })
    <?php endif; ?>

    // alert success
    <?php if (!empty(session()->getFlashdata("success_verify_account"))) : ?>
    document.addEventListener("DOMContentLoaded", () => {
        Swal.fire({
            title: "success!",
            icon: "success",
            html: `<?= session('success_verify_account') ?>`
        });
    })
    <?php endif; ?>
    </script>

    <?= $this->endSection() ?>