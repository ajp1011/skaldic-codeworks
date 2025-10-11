interface ContactInfo {
    phone: string;
    email: string;
}

export class ContactReveal {
    private interactionCount: number = 0;
    private requiredInteractions: number = 2;
    private botScore: number = 0;

    constructor() {
        this.init();
    }

    private init(): void {
        this.trackUserInteractions();
        this.setupRevealTriggers();
        this.detectBots();
        this.setupHoneypot();
    }

    private getContactInfo(): ContactInfo {
        return {
            phone: this.reconstructPhone(),
            email: this.reconstructEmail()
        };
    }

    private reconstructPhone(): string {
        const parts = ['5', '8', '5', '-', '3', '5', '8', '-', '1', '3', '0', '0'];
        return '(' + parts.slice(0, 3).join('') + ') ' + 
               parts.slice(4, 7).join('') + '-' + 
               parts.slice(8).join('');
    }

    private reconstructEmail(): string {
        const user = ['a', 'j', 'p', '1', '0', '1', '1'].join('');
        const domain = ['g', 'm', 'a', 'i', 'l'].join('');
        const tld = 'com';
        return `${user}@${domain}.${tld}`;
    }

    private trackUserInteractions(): void {
        // Track mouse movement
        document.addEventListener('mousemove', () => {
            if (this.interactionCount < this.requiredInteractions) {
                this.interactionCount++;
            }
        }, { once: false, passive: true });

        // Track scrolling
        document.addEventListener('scroll', () => {
            if (this.interactionCount < this.requiredInteractions) {
                this.interactionCount++;
            }
        }, { once: true, passive: true });
    }

    private setupRevealTriggers(): void {
        document.addEventListener('click', (e: MouseEvent) => {
            const trigger = (e.target as HTMLElement).closest('.reveal-trigger');
            if (!trigger) return;

            if (this.interactionCount < this.requiredInteractions) {
                alert('Please interact with the page first (scroll or move mouse)');
                return;
            }

            const type = trigger.getAttribute('data-type');
            const parent = trigger.closest('.contact-phone, .contact-email');
            if (!parent) return;

            const hiddenSpan = parent.querySelector('.contact-hidden') as HTMLElement;
            if (!hiddenSpan) return;

            if (type === 'phone') {
                this.revealPhone(hiddenSpan, trigger as HTMLElement);
            } else if (type === 'email') {
                this.revealEmail(hiddenSpan, trigger as HTMLElement);
            }
        });
    }

    private revealPhone(container: HTMLElement, trigger: HTMLElement): void {
        const phone = this.getContactInfo().phone;
        container.textContent = phone;
        container.style.display = 'inline';
        trigger.style.display = 'none';
    }

    private revealEmail(container: HTMLElement, trigger: HTMLElement): void {
        const email = this.getContactInfo().email;
        const link = document.createElement('a');
        link.href = `mailto:${email}`;
        link.textContent = email;
        link.className = 'contact-link';
        container.appendChild(link);
        container.style.display = 'inline';
        trigger.style.display = 'none';
    }

    private detectBots(): void {
        // Check for lack of mouse movement after 3 seconds
        setTimeout(() => {
            if (this.interactionCount === 0) {
                this.botScore += 20;
            }
        }, 3000);

        if (navigator.webdriver) {
            this.botScore += 50;
        }

        if (!navigator.languages || navigator.languages.length === 0) {
            this.botScore += 30;
        }
    }

    private setupHoneypot(): void {
        const honeypot = document.querySelector('[aria-hidden="true"]');
        if (!honeypot) return;

        const observer = new MutationObserver(() => {
            this.botScore = 100;
            console.warn('Bot detected: Honeypot tampering');
        });

        observer.observe(honeypot, {
            childList: true,
            subtree: true,
            attributes: true
        });
    }

    public getBotScore(): number {
        return this.botScore;
    }

    public isLikelyBot(): boolean {
        return this.botScore >= 50;
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        new ContactReveal();
    });
} else {
    new ContactReveal();
}
