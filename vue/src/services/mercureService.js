import { EventSourcePolyfill } from 'event-source-polyfill';

class MercureService {
    constructor(topic, jwt, user, loggedUser) {
        this.topic = topic;
        this.jwt = jwt;
        this.user = user;
        this.loggedUser = loggedUser;
        this.eventSource = null;
    }

    listen(callback) {
        if (this.eventSource) {
            this.eventSource.close();
        }

        this.eventSource = new EventSourcePolyfill(`http://localhost:3000/.well-known/mercure?topic=${this.topic}`, {
            headers: {
                'Authorization': `Bearer ${this.jwt}`,
            },
        });

        this.eventSource.addEventListener('message', (event) => {
            try {
                const jsonData = JSON.parse(event.data);

                if (jsonData && jsonData.message) {
                    callback({
                        id: crypto.randomUUID(),
                        message: jsonData.message,
                        name: this.user,
                        time: "now",
                        type: "received",
                        userId: this.loggedUser
                    });
                } else {
                    console.warn('Message non trouvé dans les données reçues.');
                }
            } catch (e) {
                console.error('Erreur lors de la conversion des données:', e);
            }
        });
    }

    close() {
        if (this.eventSource) {
            this.eventSource.close();
        }
    }
}

export default MercureService;
