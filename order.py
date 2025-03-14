import sqlite3
import requests
import datetime

# Webhook URL
WEBHOOK_URL = "https://discord.com/api/webhooks/1349850414543142912/your-webhook"

# Verbindung zur Datenbank
conn = sqlite3.connect('shop.db')
cursor = conn.cursor()

# Tabelle für Bestellungen erstellen
cursor.execute('''CREATE TABLE IF NOT EXISTS orders (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    name TEXT,
                    product TEXT,
                    date TEXT)''')

# Bestellung speichern & senden
def order_product(name, product):
    date = datetime.datetime.now().strftime("%d.%m.%Y %H:%M")
    
    # Datenbank speichern
    cursor.execute("INSERT INTO orders (name, product, date) VALUES (?, ?, ?)", (name, product, date))
    conn.commit()

    # Webhook senden
    message = {
        "username": "Goodboy Shop",
        "embeds": [{
            "title": "🛒 **Neue Bestellung erhalten!**",
            "color": 16753920,
            "fields": [
                {"name": "🛍️ **Produkt:**", "value": f"**{product}**", "inline": False},
                {"name": "👤 **Besteller:**", "value": f"**{name}**", "inline": False},
                {"name": "📅 **Bestellzeit:**", "value": f"**{date}**", "inline": False}
            ]
        }]
    }
    
    requests.post(WEBHOOK_URL, json=message)
    print("✅ Bestellung erfolgreich gesendet!")

# Testfunktion
order_product("Max Mustermann", "FiveM Premium Mod Menü")
