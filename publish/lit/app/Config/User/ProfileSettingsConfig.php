<?php

namespace LitApp\Config\User;

use Lit\Crud\Config\CrudConfig;
use Lit\Crud\CrudShow;
use Lit\User\Models\LitUser;
use LitApp\Controllers\User\ProfileSettingsController;

class ProfileSettingsConfig extends CrudConfig
{
    /**
     * Model class.
     *
     * @var string
     */
    public $model = LitUser::class;

    /**
     * Controller class.
     *
     * @var string
     */
    public $controller = ProfileSettingsController::class;

    /**
     * Model singular and plural name.
     *
     * @return array
     */
    public function names()
    {
        $profileSettingsName = ucwords(__lit('base.item_settings', [
            'item' => __lit('base.profile'),
        ]));

        return [
            'singular' => $profileSettingsName,
            'plural'   => $profileSettingsName,
        ];
    }

    /**
     * Route prefix.
     *
     * @return string
     */
    public function routePrefix()
    {
        return 'profile';
    }

    /**
     * Setup create and edit form.
     *
     * @param \Lit\Crud\CrudShow $page
     *
     * @return void
     */
    public function show(CrudShow $page)
    {
        // settings
        $page->info(ucwords(__lit('base.general')))->width(4);
        $page->card(fn ($form) => $this->settings($form))
            ->width(8)->class('mb-5');

        // language
        $this->language($page);

        // security
        $page->info(ucwords(__lit('base.security')))->width(4);

        $page->group(function ($page) {
            $page->card(fn ($form) => $this->security($form));
            $page->component('lit-profile-security');
        })->width(8);
    }

    /**
     * Profile settings.
     *
     * @param CrudShow $form
     *
     * @return void
     */
    public function settings($form)
    {
        $form->input('first_name')
            ->width(6)
            ->title(ucwords(__lit('base.first_name')));

        $form->input('last_name')
            ->width(6)
            ->title(ucwords(__lit('base.last_name')));

        $form->modal('change_email')
            ->title('E-Mail')
            ->variant('primary')
            ->preview('{email}')
            ->name('Change E-Mail')
            ->confirmWithPassword()
            ->form(function ($modal) {
                $modal->input('email')
                    ->width(12)
                    ->rules('required')
                    ->title('E-Mail');
            })->width(6);

        $form->input('username')
            ->width(6)
            ->title(ucwords(__lit('base.username')));
    }

    /**
     * Change language.
     *
     * @param CrudShow $form
     *
     * @return void
     */
    public function language($form)
    {
        if (! config('lit.translatable.translatable')) {
            return;
        }

        $form->info(ucwords(__lit('base.language')))->width(4)
            ->text(__lit('profile.messages.language'));

        $form->card(fn ($form) => $form->component('lit-locales')->class('mb-4'))
            ->width(8)
            ->class('mb-5');
    }

    /**
     * User security.
     * - Change password
     * - Session manager.
     *
     * @param CrudShow $container
     *
     * @return void
     */
    public function security($form)
    {
        $form->modal('change_password')
            ->title('Password')
            ->variant('primary')
            ->name(fa('user-shield').' '.__lit('profile.change_password'))
            ->form(function ($modal) {
                $modal->password('old_password')
                    ->title('Old Password')
                    ->confirm();

                $modal->password('password')
                    ->title('New Password')
                    ->rules('required', 'min:5')
                    ->minScore(0);

                $modal->password('password_confirmation')
                    ->rules('required', 'same:password')
                    ->dontStore()
                    ->title('New Password')
                    ->noScore();
            });
    }
}
