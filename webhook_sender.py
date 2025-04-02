from flask import Flask, request, render_template_string
import requests

app = Flask(__name__)

# 👉 Deinen Discord Webhook hier einfügen
DISCORD_WEBHOOK_URL = "https://discord.com/api/webhooks/1357065885495328882/vW2q2yAjYeK9r-Ys5TdQBKaqm8-6m7xgduC112zuyLT6ClG64ccIakUqmP-T16AxTN1H"

HTML_PAGE = '''
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Discord Nachricht senden</title>
    <style>
        body {
            background-color: #2c2f33;
            color: #ffffff;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 60px;
        }
        .container {
            background-color: #23272a;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.4);
            width: 90%;
            max-width: 500px;
        }
        textarea {
            width: 100%;
            height: 120px;
            border-radius: 6px;
            padding: 10px;
            font-size: 16px;
            border: none;
            resize: none;
        }
        input[type="submit"] {
            margin-top: 15px;
            width: 100%;
            background-color: #7289da;
            border: none;
            padding: 10px;
            font-size: 16px;
            color: white;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #5b6eae;
        }
        .message {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Nachricht an Discord senden</h2>
        <form method="POST">
            <textarea name="message" placeholder="Deine Nachricht an Discord..."></textarea>
            <input type="submit" value="Senden">
        </form>
        {% if success is not none %}
            <div class="message" style="color: {{ 'lime' if success else 'red' }}">
                {{ '✅ Nachricht wurde gesendet!' if success else '❌ Fehler beim Senden!' }}
            </div>
        {% endif %}
    </div>
</body>
</html>
'''

@app.route("/", methods=["GET", "POST"])
def send_message():
    success = None
    if request.method == "POST":
        message = request.form.get("message")
        if message:
            response = requests.post(DISCORD_WEBHOOK_URL, json={"content": message})
            success = response.status_code == 204
    return render_template_string(HTML_PAGE, success=success)

if __name__ == "__main__":
    app.run(debug=True)
