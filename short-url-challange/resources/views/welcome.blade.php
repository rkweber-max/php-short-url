<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
            rel="stylesheet">
    </head>
    <body>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-header text-center bg-primary text-white">
                            <h3>URL Shortener</h3>
                        </div>
                        <div class="card-body">
                            <form id="shorten-form">
                                <div class="mb-3">
                                    <label for="original-url" class="form-label">Enter URL to Shorten</label>
                                    <input type="url" class="form-control" id="original-url" name="original_url" placeholder="https://example.com" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Shorten URL</button>
                            </form>
                            <div class="mt-3" id="result" style="display: none;">
                                <div class="alert alert-success">
                                    <h5>Shortened URL:</h5>
                                    <a href="#" target="_blank" id="short_url" class="btn btn-outline-primary"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <script>
        document.getElementById('shorten-form').addEventListener('submit', function(event) {
            event.preventDefault();

            const originalUrl = document.getElementById('original-url').value;
            const submitButton = document.querySelector('button[type="submit"]');

            submitButton.disabled = true;
            submitButton.textContent = 'Encurtando...';

            fetch('{{ route('url.short') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ original_url: originalUrl })
            })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => {
                        throw new Error(`HTTP ${response.status}: ${text}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.short_url) {
                    const shortUrlElement = document.getElementById('short_url');
                    shortUrlElement.href = data.short_url;
                    shortUrlElement.textContent = data.short_url;
                    document.getElementById('result').style.display = 'block';
                } else {
                    throw new Error('URL encurtada não foi retornada');
                }
            })
            .catch(error => {
                alert('Erro ao encurtar a URL: ' + error.message);
            })
            .finally(() => {
                submitButton.disabled = false;
                submitButton.textContent = 'Shorten URL';
            });
        });
        </script>
    </body>
</html>
