import sqlite3
import requests
import datetime

# Discord Webhook URL
WEBHOOK_URL = "https://discord.com/api/webhooks/1349850414543142912/your-webhook"

# Verbindung zur SQLite-Datenbank
conn = sqlite3.connect('shop.db')
cursor = conn.cursor()

# Tabelle für Bestellungen erstellen
cursor.execute('''CREATE TABLE IF NOT EXISTS orders (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    name TEXT,
                    product TEXT,
                    date TEXT)''')

def order_product(name, product):
    date = datetime.datetime.now().strftime("%d.%m.%Y %H:%M")

    # Bestellung in Datenbank speichern
    cursor.execute("INSERT INTO orders (name, product, date) VALUES (?, ?, ?)", (name, product, date))
    conn.commit()

    # Nachricht für Discord vorbereiten
    message = {
        "username": "Goodboy Shop",
        "embeds": [{
            "title": "🛒 **Neue Bestellung erhalten!**",
            "color": 16753920,
            "fields": [
                {"name": "🛍️ **Produkt:**", "value": f"**{product}**", "inline": False},
                {"name": "👤 **Besteller:**", "value": f"**{name}**", "inline": False},
                {"name": "📅 **Bestellzeit:**", "value": f"**{date}**", "inline": False}
            ],
            "footer": {"text": "Goodboy Shop - Powered by Discord"}
        }]
    }

    # Bestellung an Discord senden
    requests.post(WEBHOOK_URL, json=message)
    print("✅ Bestellung erfolgreich gesendet!")

# Testbestellung
order_product("Max Mustermann", "FiveM Premium Mod Menü")
