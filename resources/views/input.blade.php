<form action="{{ route('generate-pdf') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div>
        <label for="name">Nama:</label>
        <input type="text" name="name" id="name" required>
    </div>
    <div>
        <label for="photo">Foto:</label>
        <input type="file" name="photo" id="photo" required>
    </div>
    <div>
        <label for="cv">CV (PDF):</label>
        <input type="file" name="cv" id="cv" accept="application/pdf" required>
    </div>
    <button type="submit">Generate PDF</button>
</form>
