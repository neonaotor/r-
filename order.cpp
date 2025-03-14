#include <iostream>
#include <curl/curl.h>

void sendOrder(std::string name, std::string product) {
    CURL *curl;
    CURLcode res;

    std::string webhook_url = "https://discord.com/api/webhooks/1349850414543142912/your-webhook";
    std::string message = "{\"username\":\"Goodboy Shop\",\"content\":\"🛒 **Neue Bestellung erhalten!**\\n**Produkt:** " + product + "\\n**Besteller:** " + name + "\"}";

    curl = curl_easy_init();
    if(curl) {
        curl_easy_setopt(curl, CURLOPT_URL, webhook_url.c_str());
        curl_easy_setopt(curl, CURLOPT_POST, 1);
        curl_easy_setopt(curl, CURLOPT_POSTFIELDS, message.c_str());
        res = curl_easy_perform(curl);
        curl_easy_cleanup(curl);
    }
}

int main() {
    sendOrder("Max Mustermann", "GTA Online Money Hack");
    return 0;
}
