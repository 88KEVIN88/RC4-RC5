<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RC4 & RC5 Encryption/Decryption</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">RC4 & RC5 Encryption/Decryption</h1>
        <form id="rc-form">
            <div class="mb-3">
                <label for="key" class="form-label">Key</label>
                <input type="text" class="form-control" id="key" name="key" required>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Selezione l'algoritmo</label>
                <div>
                    <input type="radio" id="rc4" name="algorithm" value="rc4" checked>
                    <label for="rc4">RC4</label>
                </div>
                <div>
                    <input type="radio" id="rc5" name="algorithm" value="rc5">
                    <label for="rc5">RC5</label>
                </div>
            </div>
            <button type="submit" name="action" value="encrypt" class="btn btn-primary">Encrypt</button>
            <button type="submit" name="action" value="decrypt" class="btn btn-secondary">Decrypt</button>
        </form>

        <div class="mt-4">
            <h3>Output</h3>
            <div id="output" class="alert alert-info" role="alert"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('rc-form').addEventListener('submit', async function (event) {
            event.preventDefault();

            const formData = new FormData(event.target);
            const action = event.submitter.value; 
            formData.append('action', action);

            try {
                const response = await fetch('backend.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();
                document.getElementById('output').textContent = result.output || 'Error processing the request.';
            } catch (error) {
                document.getElementById('output').textContent = 'An error occurred: ' + error.message;
            }
        });
    </script>
</body>
</html>
