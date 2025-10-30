class SnowEffect {
  private canvas: HTMLCanvasElement;
  private ctx: CanvasRenderingContext2D;
  private particles: SnowParticle[] = [];
  private animationId: number | null = null;
  private resizeHandler: () => void;

  constructor(containerId: string) {
    const container = document.getElementById(containerId);
    if (!container) {
      throw new Error(`Container with id "${containerId}" not found`);
    }

    this.canvas = document.createElement('canvas');
    this.canvas.className = 'snow-canvas';
    this.canvas.style.cssText = `
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
      z-index: 1;
    `;

    container.appendChild(this.canvas);
    this.ctx = this.canvas.getContext('2d')!;

    this.resizeHandler = () => this.resizeCanvas();

    this.init();
  }

  private init(): void {
    this.resizeCanvas();
    this.createParticles();
    this.animate();
    window.addEventListener('resize', this.resizeHandler);
  }

  private resizeCanvas(): void {
    this.canvas.width = window.innerWidth;
    this.canvas.height = window.innerHeight;
  }

  private createParticles(): void {
    this.particles = [];
    const particleCount = 80;
    for (let i = 0; i < particleCount; i++) {
      const particle = this.createParticle();
      particle.y = Math.random() * window.innerHeight;
      this.particles.push(particle);
    }
  }

  private createParticle(): SnowParticle {
    return {
      x: Math.random() * window.innerWidth,
      y: Math.random() * -100,
      size: Math.random() * 3 + 1,
      speed: Math.random() * 2 + 0.5,
      opacity: Math.random() * 0.8 + 0.2,
      drift: Math.random() * 0.5 - 0.25,
      rotation: Math.random() * Math.PI * 2,
      rotationSpeed: Math.random() * 0.02 - 0.01
    };
  }

  private drawParticle(particle: SnowParticle): void {
    this.ctx.save();
    this.ctx.translate(particle.x, particle.y);
    this.ctx.rotate(particle.rotation);
    
    // Create icy snowflake shape
    this.ctx.strokeStyle = `rgba(129, 199, 212, ${particle.opacity})`;
    this.ctx.fillStyle = `rgba(200, 220, 240, ${particle.opacity * 0.3})`;
    this.ctx.lineWidth = 0.5;
    
    // Draw hexagonal snowflake
    const size = particle.size;
    const centerX = 0;
    const centerY = 0;
    
    this.ctx.beginPath();
    for (let i = 0; i < 6; i++) {
      const angle = (i * Math.PI) / 3;
      const x = centerX + Math.cos(angle) * size;
      const y = centerY + Math.sin(angle) * size;
      
      if (i === 0) {
        this.ctx.moveTo(x, y);
      } else {
        this.ctx.lineTo(x, y);
      }
    }
    this.ctx.closePath();
    this.ctx.fill();
    this.ctx.stroke();
    
    // Add inner details for more realistic snowflake
    this.ctx.beginPath();
    for (let i = 0; i < 6; i++) {
      const angle = (i * Math.PI) / 3;
      const innerX = centerX + Math.cos(angle) * (size * 0.5);
      const innerY = centerY + Math.sin(angle) * (size * 0.5);
      
      if (i === 0) {
        this.ctx.moveTo(innerX, innerY);
      } else {
        this.ctx.lineTo(innerX, innerY);
      }
    }
    this.ctx.closePath();
    this.ctx.stroke();
    
    this.ctx.restore();
  }

  private updateParticle(particle: SnowParticle): void {
    particle.y += particle.speed;
    particle.x += particle.drift;
    particle.rotation += particle.rotationSpeed;
    
    // Add slight swaying motion
    particle.drift += Math.sin(particle.y * 0.01) * 0.01;
    
    // Reset particle if it goes off screen
    if (particle.y > window.innerHeight + 10) {
      particle.y = -10;
      particle.x = Math.random() * window.innerWidth;
    }
    
    if (particle.x < -10) {
      particle.x = window.innerWidth + 10;
    } else if (particle.x > window.innerWidth + 10) {
      particle.x = -10;
    }
  }

  private animate = (): void => {
    // Clear canvas
    this.ctx.clearRect(0, 0, window.innerWidth, window.innerHeight);
    
    // Update and draw particles
    this.particles.forEach(particle => {
      this.updateParticle(particle);
      this.drawParticle(particle);
    });
    
    this.animationId = requestAnimationFrame(this.animate);
  };

  public destroy(): void {
    if (this.animationId) {
      cancelAnimationFrame(this.animationId);
    }
    window.removeEventListener('resize', this.resizeHandler);
    this.canvas.remove();
  }
}

interface SnowParticle {
  x: number;
  y: number;
  size: number;
  speed: number;
  opacity: number;
  drift: number;
  rotation: number;
  rotationSpeed: number;
}

// Initialize snow effect when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
  new SnowEffect('snow-container');
});

export default SnowEffect;
