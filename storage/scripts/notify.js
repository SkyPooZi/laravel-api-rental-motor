const { makeWASocket, useMultiFileAuthState, DisconnectReason } = require('@whiskeysockets/baileys');
const { Boom } = require('@hapi/boom');

// Setup authentication state storage
async function connectToWhatsApp() {
    const { state, saveCreds } = await useMultiFileAuthState('auth_info_baileys');
    const sock = makeWASocket({
        auth: state,
        printQRInTerminal: true, // Print QR code in the terminal for first-time connection
    });

    sock.ev.on('connection.update', (update) => {
        const { connection, lastDisconnect } = update;
        if (connection === 'close') {
            const shouldReconnect = (new Boom(lastDisconnect.error)).output.statusCode !== DisconnectReason.loggedOut;
            console.log('Connection closed due to', lastDisconnect.error, ', reconnecting', shouldReconnect);
            if (shouldReconnect) {
                connectToWhatsApp(); // Reconnect if not logged out
            }
        } else if (connection === 'open') {
            console.log('Connected successfully');
        }
    });

    sock.ev.on('creds.update', saveCreds);

    return sock;
}

async function sendWhatsAppNotification(history_id, pesan, no_telp) {
    try {
        const sock = await connectToWhatsApp();

        // Wait for the connection to open before sending the message
        sock.ev.on('connection.update', async (update) => {
            if (update.connection === 'open') {
                // Format message
                const formattedMessage = `
*Notifkasi Rental Motor Kudus*

------------------------------------------------------------------------------------------

${pesan}

Terima Kasih,
Rental Motor Kudus

------------------------------------------------------------------------------------------

Rental Motor Kudus
Trengguluh, Honggosoco, Kec. Jekulo, Kabupaten Kudus, Jawa Tengah
Indonesia
`;

                // Ensure the phone number is correctly formatted for WhatsApp
                const id = `${no_telp}@s.whatsapp.net`; // Format number correctly for Indonesia

                // Send message
                try {
                    await sock.sendMessage(id, { text: formattedMessage });
                    console.log('Message sent successfully!');
                } catch (sendError) {
                    console.error('Error sending message:', sendError);
                }
            }
        });
    } catch (error) {
        console.error('Error connecting to WhatsApp:', error);
    }
}

sendWhatsAppNotification(history_id, pesan, no_telp).catch(console.error);

