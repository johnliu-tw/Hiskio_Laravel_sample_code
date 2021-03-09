<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

// Custom
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;

class ExperienceFeatureTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @return void
     */

    protected function setUp(): void
    {
        parent::setUp();
        User::factory()->create([
            'email' => 'john@john.com',
        ]);
        Artisan::call("db:seed", ['--class' => 'ProductSeeder']);
    }


    protected function driver()
    {
        $options = (new ChromeOptions)->addArguments([
                //'--disable-gpu',
                //'--headless'
        ]);
    
        return RemoteWebDriver::create(
            'http://localhost:9515',
            DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY,
                $options
            )
        );
    }
    public function testFeatureUse()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->with('.special-text', function ($text) {
                        $text->assertSee('固定資料');
                    });

            $browser->click('.check_product')
                    ->waitForDialog(5)
                    ->assertDialogOpened('商品數量充足')
                    ->acceptDialog();
        });

        // Method should be talked
        // 1. scrollToElement
        // 2. wait
    }

    public function testFillForm()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('contactUs')
                    ->value('[name="name"]', 'cool')
                    ->select('[name="product"]', '食品')
                    ->press('送出')
                    ->assertQueryStringHas('product', '食品');
        });
    }
}
