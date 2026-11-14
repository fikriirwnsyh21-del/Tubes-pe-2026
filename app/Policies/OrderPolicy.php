<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    /**
     * Determine whether the user can view the order.
     */
    public function view(User $user, Order $order): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $order->user_id === $user->id;
    }

    /**
     * Determine whether the user can cancel the order.
     */
    public function cancel(User $user, Order $order): bool
    {
        if ($order->status !== 'pending') {
            return false;
        }

        return $user->isAdmin() || $order->user_id === $user->id;
    }

    /**
     * Determine whether the user can update fulfillment status.
     */
    public function fulfill(User $user, Order $order): bool
    {
        return $user->isAdmin();
    }
}
