<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Example</title>

    <!-- tailwind  -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- utils  -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto">
        <div class="flex justify-center items-center h-screen">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" id="btn">Click
                me</button>
        </div>
    </div>

    <script>
    document.getElementById('btn').addEventListener('click', function() {
        Swal.fire({
            title: 'Hello World!',
            text: 'This is a simple example',
            icon: 'success',
            confirmButtonText: 'Cool'
        })
    })
    </script>

</body>

</html>