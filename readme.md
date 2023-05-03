We expect config options for

- `GOOGLE_RECAPTCHA_SECRET_KEY`
- `GOOGLE_RECAPTCHA_SITE_KEY`

These should be defined in your `config/packages/maric_trading_recaptcha.yaml` file.  

An exception will be thrown when using the form type when they don't exist.

## Usage

Install with composer

Add the extension in your `config/bundles.php` file.

```php
    MaricTrading\Recaptcha\MaricTradingRecaptchaBundle::class => ['all' => true],
```

Add the config settings to `config/packages/maric_trading_recaptcha.yaml`

```yaml
maric_trading_recaptcha:
  GOOGLE_RECAPTCHA_SITE_KEY: your-site-key
  GOOGLE_RECAPTCHA_SECRET_KEY: your-secret-key
```



Add the form type to your form INSTEAD of a normal submit button.

```php
            ->add("recaptcha", RecaptchaFormType::class,[
                "label"=>"Register",
                "mapped"=>false,
                "required"=>true,
            ])
```




Inject the service into the method where you want to process the form.


```php
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, MailerInterface $mailer, RecaptchaService $recaptcha): Response
    {
```

Verify the form result.

```php
            $recaptchaResult = $recaptcha->verify($token);
            if (!$recaptchaResult) {
                $this->addFlash("danger", "reCAPTCHA failed.  Please try again.");
                return $this->redirectToRoute('app_register');
            }
```

Process the remnainder of the form.


