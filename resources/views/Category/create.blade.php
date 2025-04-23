@extends('Dash')

@section('content')

<div class="container mt-4">
    <h1 class="text-center mb-4" style="color: hsl(25, 73.00%, 34.90%); font-size: 2.5rem; font-weight: bold;">Add New Category</h1>

    <div class="form-container">
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Category Name</label>
                <input type="text" id="name" name="name" placeholder="Category Name" required>
            </div>
            <div class="form-group text-center">
                <button type="submit" style="font-size: 1.2rem; padding: 0.6rem 1.2rem; background-color: hsl(25, 73.00%, 34.90%); color: white; border: none; border-radius: 5px; margin-right: 10px;">Submit</button>
                <button type="button" style="font-size: 1rem; padding: 0.4rem 1rem; background-color: #ddd; color: #333; border: none; border-radius: 5px;">Back</button>
            </div>
        </form>
        <div class="form-footer">
            <p>💡 Please ensure the data is correct before submitting</p>
        </div>
    </div>
</div>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        color: #333;
    }
    .form-container {
        background: #ffffff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        margin: 0 auto;
        width: 100%;
        max-width: 400px;
    }
    .form-container h2 {
        margin-bottom: 20px;
        color: hsl(25, 73.00%, 34.90%);
        text-align: center;
    }
    .form-group {
        margin-bottom: 15px;
    }
    label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }
    input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 1rem;
    }
    .form-footer {
        text-align: center;
        margin-top: 20px;
        font-size: 0.9rem;
    }
</style>
@endsection
