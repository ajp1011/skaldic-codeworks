/**
 * Spark Effect - Forgecraft Modern Theme
 * Creates rising ember sparks effect
 */

class SparkEffect {
  private canvas: HTMLCanvasElement;
  private ctx: CanvasRenderingContext2D;
  private particles: SparkParticle[] = [];
  private animationId: number | null = null;
  private resizeHandler: () => void;

  constructor(containerId: string) {
    const container = document.getElementById(containerId);
    if (!container) {
      throw new Error(`Container with id "${containerId}" not found`);
    }

    this.canvas = document.createElement('canvas');
    this.canvas.className = 'spark-canvas';
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
    const particleCount = 60;
    for (let i = 0; i < particleCount; i++) {
      const particle = this.createParticle();
      particle.y = Math.random() * window.innerHeight;
      this.particles.push(particle);
    }
  }

  private createParticle(): SparkParticle {
    return {
      x: Math.random() * window.innerWidth,
      y: window.innerHeight + 10,
      size: Math.random() * 2.5 + 1,
      speed: Math.random() * 2 + 1,
      opacity: Math.random() * 0.8 + 0.3,
      drift: Math.random() * 0.8 - 0.4,
      life: 1.0,
      decay: Math.random() * 0.003 + 0.002,
      color: this.getSparkColor()
    };
  }

  private getSparkColor(): string {
    const colors = [
      'rgba(255, 107, 53, ',  // Ember orange
      'rgba(255, 140, 66, ',  // Light orange
      'rgba(255, 166, 0, ',   // Amber
      'rgba(193, 68, 14, ',   // Molten red
    ];
    const weights = [0.4, 0.3, 0.2, 0.05];
    const random = Math.random();
    let sum = 0;
    
    for (let i = 0; i < weights.length; i++) {
      sum += weights[i];
      if (random < sum) {
        return colors[i];
      }
    }
    
    return colors[0];
  }

  private drawParticle(particle: SparkParticle): void {
    this.ctx.save();
    
    const opacity = particle.opacity * particle.life;
    
    // Draw glow
    const gradient = this.ctx.createRadialGradient(
      particle.x, particle.y, 0,
      particle.x, particle.y, particle.size * 3
    );
    gradient.addColorStop(0, particle.color + opacity + ')');
    gradient.addColorStop(0.5, particle.color + (opacity * 0.3) + ')');
    gradient.addColorStop(1, particle.color + '0)');
    
    this.ctx.fillStyle = gradient;
    this.ctx.beginPath();
    this.ctx.arc(particle.x, particle.y, particle.size * 3, 0, Math.PI * 2);
    this.ctx.fill();
    
    // Draw spark core
    this.ctx.fillStyle = particle.color + opacity + ')';
    this.ctx.beginPath();
    this.ctx.arc(particle.x, particle.y, particle.size, 0, Math.PI * 2);
    this.ctx.fill();
    
    this.ctx.restore();
  }

  private updateParticle(particle: SparkParticle): void {
    particle.y -= particle.speed;
    particle.x += particle.drift;
    particle.life -= particle.decay;
    
    // Add flickering effect
    particle.opacity = 0.3 + Math.sin(Date.now() * 0.01 + particle.x) * 0.5;
    
    // Reset particle if it fades out or goes off top
    if (particle.life <= 0 || particle.y < -10) {
      Object.assign(particle, this.createParticle());
    }
    
    // Wrap horizontally
    if (particle.x < -10) {
      particle.x = window.innerWidth + 10;
    } else if (particle.x > window.innerWidth + 10) {
      particle.x = -10;
    }
  }

  private animate = (): void => {
    this.ctx.clearRect(0, 0, window.innerWidth, window.innerHeight);
    
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

interface SparkParticle {
  x: number;
  y: number;
  size: number;
  speed: number;
  opacity: number;
  drift: number;
  life: number;
  decay: number;
  color: string;
}

// Initialize spark effect when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
  const container = document.getElementById('spark-container');
  if (container) {
    new SparkEffect('spark-container');
  }
});

export default SparkEffect;

