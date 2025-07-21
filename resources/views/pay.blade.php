<!DOCTYPE html>
<html>
<head>
    <title>Paystack Payment</title>
</head>
<body>
    <h2>Pay with Paystack</h2>
    <form method="POST" action="{{ route('paystack.pay') }}">
        @csrf
        <label>Email:</label>
        <input type="email" name="email" required>
        <br><br>
        <label>Amount:</label>
        <input type="number" name="amount" required>
        <br><br>
        <button type="submit">Pay Now</button>
    </form>
</body>
</html>
