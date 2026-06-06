<?php

namespace App\Composer;

use Illuminate\Support\Facades\Auth;

class SidebarComposer
{
    public $menus = [];

    public function getSidebarMenus()
    {
        if (Auth::check()) {
            $this->menus[] = [
                'title' => __('Dashboard'),
                'path' => route('home'), //route('dashboard'),
                'icon' => 'mdi-home-variant-outline',
            ];

            if (request()->user()->can('Access POS')) {
                $this->menus[] = [
                    'title' => __('Sales'),
                    'path' => route('pos.create'),
                    'icon' => 'mdi-shopping',
                ];
            }
            if (request()->user()->can('Access POS')) {
                $this->menus[] = [
                    'title' => __('Sell list'),
                    'path' => route('pos.index'),
                    'icon' => 'mdi-package',
                ];
            }
            if (request()->user()->can('Access Sales Entry')) {
                $this->menus[] = [
                    'title' => __('Sale Update'),
                    'path' => route('stocks.create', ['type' => 'sale']),
                    'icon' => 'mdi-package',
                ];
            }
            if (request()->user()->can('Access Sales Entry')) {
                $this->menus[] = [
                    'title' => __('Gold Buy Sale'),
                    'path' => route('gold-buy-sale'),
                    'icon' => 'mdi-package',
                ];
            }
            $this->menus[] = [
                'title' => __('Jakat'),
                'path' => route('jakat.index'),
                'icon' => 'mdi-package',
            ];
            if (request()->user()->can('Access Booking')) {
                $this->menus[] = [
                    'title' => __('Add Booking'),
                    'path' => route('booking.create'),
                    'icon' => 'mdi-shopping',
                ];
            }
            if (request()->user()->can('Access Booking')) {
                $this->menus[] = [
                    'title' => __('Booking'),
                    'path' => route('booking.index'),
                    'icon' => 'mdi-shopping',
                ];
            }
            if (request()->user()->can('Access Clients')) {
                $this->menus[] = [
                    'title' => __('Customers'),
                    'path' => route('clients.index'),
                    'icon' => 'mdi-account-supervisor',
                ];
            }
            if (request()->user()->can('Access Products')) {
                $this->menus[] = [
                    'title' => __('Products'),
                    'path' => route('products.index'),
                    'icon' => 'mdi-diamond-stone',
                ];
            }
            if (request()->user()->can('Access Cash Book')) {
                $this->menus[] = [
                    'title' => __('Cash Book'),
                    'path' => route('cash.book.report'),
                    'icon' => 'mdi-diamond-stone',
                ];
            }
            if (request()->user()->can('Access Customer Due')) {
                $this->menus[] = [
                    'title' => __('Advance & Due'),
                    'path' => "#",
                    'icon' => 'mdi-diamond-stone',
                    'submenus' => $this->getDueChildren(),
                ];
            }
            if (request()->user()->can('Access Stock')) {
                $this->menus[] = [
                    'title' => __('Stock'),
                    'path' => route('stocks.index'),
                    'icon' => 'mdi-diamond-stone',
                ];
            }
            if (request()->user()->can('Access Expenses')) {
                $this->menus[] = [
                    'title' => __('Expenses'),
                    'path' => route('expenses.index'),
                    'icon' => 'mdi-alpha-s-box-outline',
                ];
            }
        }

        if (request()->user()->can('Access Sale Settings')) {
            $this->menus[] = [
                'title' => __('Settings'),
                'path' => "#",
                'icon' => 'mdi-account-supervisor',
                'submenus' => $this->getSaleSettingsChildren()
            ];
        }



        return $this->menus;
    }

    public function getDueChildren()
    {
        $menus = [];
        if (request()->user()->can('Access Customer Due')) {
            $menus[] = [
                'title' => __('Customer Transaction'),
                'path' => route('transactions.index'),
            ];

        }
        if (request()->user()->can('Access Suppliers Transaction')) {
            $menus[] = [
                'title' => __('Supplier Transaction'),
                'path' => route('suppliers.due'),
            ];

        }
        if (request()->user()->can('Access Report')) {
            $menus[] = [
                'title' => __('Report'),
                'path' => route('report'),
            ];

        }
        if (request()->user()->can('Access Expenses')) {
            $menus[] = [
                'title' => __('Expenses Report'),
                'path' => route('expenses-report.create'),
            ];

        }
        return $menus;
    }

    public function getSaleSettingsChildren()
    {
        $menus = [];

        if (request()->user()->can('Access ProductCategorys')) {
            $menus[] = [
                'title' => __('Product Category'),
                'path' => route('product-categories.index'),

            ];
        }
        if (request()->user()->can('Access TodayRates')) {
            $menus[] = [
                'title' => __('Today Rate'),
                'path' => route('today-rates.index'),

            ];
        }

        $menus[] = [
            'title' => __('Sale Type'),
            'path' => route('sale-types.index'),
        ];

        $menus[] = [
            'title' => __('Zones'),
            'path' => route('zones.index'),
        ];
        if (request()->user()->can('Access Suppliers')) {
            $menus[] = [
                'title' => __('Suppliers'),
                'path' => route('suppliers.index'),
            ];
        }
        $menus[] = [
            'title' => __('Customer Category'),
            'path' => route('customer-categories.index'),
        ];
        $menus[] = [
            'title' => __('Payment Methods'),
            'path' => route('payment-methods.index'),
        ];
        $menus[] = [
            'title' => __('Wage Setting'),
            'path' => route('wage-setting.create'),
        ];
        $menus[] = [
            'title' => __('Transaction Code'),
            'path' => route('transaction-codes.index'),
        ];
        $menus[] = [
            'title' => __('Transaction Heads'),
            'path' => route('trx-heads.index'),
        ];
        $menus[] = [
            'title' => __('T&C'),
            'path' => route('tc.index'),
        ];
        $menus[] = [
            'title' => __('Booking T&C'),
            'path' => route('booking_tc.index'),
        ];
        $menus[] = [
            'title' => __('Settings'),
            'path' => route('settings.index'),
        ];

        if (request()->user()->can('Access Roles')) {
            $menus[] = [
                'title' => __('Roles & Permissions'),
                'path' => route('roles.index'),
            ];
        }
        if (request()->user()->can('Access Users')) {
            $menus[] = [
                'title' => __('Users'),
                'path' => route('users.index'),
            ];
        }
        return $menus;
    }

}
