<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Excel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        header, footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 15px;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }

        select,
        input[type="file"],
        button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #333;
            color: #fff;
            cursor: pointer;
        }

        button:hover {
            background-color: #555;
        }

        .alert {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<header>
    <h1>Hamed - Sheet Excel</h1>
</header>

<div class="container">
    <h2>Upload Excel File</h2>

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    <form action="{{ route('excel.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="category_id">Select Category</label>
        <select name="category_id" id="category_id" required>
            <option value="">-- Choose Category --</option>
            @foreach ($cats as $category)
                <option value="{{ $category->id }}">
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <label for="excel_file">Choose Excel File</label>
        <input type="file" name="excel_file" id="excel_file" accept=".xls,.xlsx,.csv" required>

        <button type="submit">Upload</button>
    </form>
</div>

{{--<footer>--}}
{{--    &copy; {{ date('Y') }} Your Company. All Rights Reserved.--}}
{{--</footer>--}}

</body>
</html>
