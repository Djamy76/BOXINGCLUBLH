<div class="news-page">
    <header class="legal-header">
        <div class="header-content">
            <h1 class="main-title">LE JOURNAL <span>DU RING</span></h1>
            <p class="subtitle">Toutes les rumeurs qu'on a inventées sous la douche</p>
        </div>
        <div class="diagonal-bg"></div>
    </header>

    <main class="container" style="margin-top: -50px; position: relative; z-index: 10; padding-bottom: 50px;">
        <div class="news-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
            
            <?php foreach ($articles as $article): ?>
                <article class="news-card" style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 10px 20px rgba(0,0,0,0.1); transition: 0.3s;">
                    <div class="news-img" style="height: 200px; overflow: hidden; position: relative;">
                        <img src="<?= $article['image'] ?>" alt="News" style="width: 100%; height: 100%; object-fit: cover;">
                        <span style="position: absolute; top: 15px; right: 15px; background: var(--club-red); color: white; padding: 5px 12px; font-family: var(--font-secondary); font-size: 0.8rem; border-radius: 4px;">
                            <?= $article['category'] ?>
                        </span>
                    </div>
                    
                    <div class="news-body" style="padding: 25px;">
                        <small style="color: #888; font-weight: bold;"><?= $article['date'] ?></small>
                        <h2 style="font-family: var(--font-secondary); margin: 10px 0; font-size: 1.4rem; color: var(--club-dark);">
                            <?= htmlspecialchars($article['title']) ?>
                        </h2>
                        <p style="color: #555; font-size: 0.95rem; line-height: 1.5; margin-bottom: 20px;">
                            <?= htmlspecialchars($article['content']) ?>
                        </p>
                        <a href="#" style="color: var(--club-red); font-weight: bold; text-decoration: none; border-bottom: 2px solid transparent; transition: 0.3s;" onmouseover="this.style.borderBottomColor='var(--club-red)'" onmouseout="this.style.borderBottomColor='transparent'">
                            LIRE LA SUITE →
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>

        </div>
    </main>
</div>