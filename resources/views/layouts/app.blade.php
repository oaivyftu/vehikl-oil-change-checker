<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Vehikl Oil Change Checker')</title>
    <style>
        :root {
            color-scheme: light;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #172033;
            background: #f3f5f8;
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            display: grid;
            place-items: center;
            padding: 2rem 1rem;
        }

        main {
            width: min(100%, 36rem);
            padding: clamp(1.5rem, 5vw, 2.5rem);
            background: #ffffff;
            border: 1px solid #dfe3ea;
            border-radius: 0.75rem;
            box-shadow: 0 1rem 2.5rem rgb(23 32 51 / 8%);
        }

        h1 {
            margin: 0 0 0.5rem;
            font-size: clamp(1.75rem, 6vw, 2.25rem);
            line-height: 1.15;
        }

        .intro {
            margin: 0 0 2rem;
            color: #586174;
        }

        .field {
            margin-bottom: 1.25rem;
        }

        label {
            display: block;
            margin-bottom: 0.4rem;
            font-weight: 650;
        }

        input {
            width: 100%;
            padding: 0.75rem 0.875rem;
            border: 1px solid #abb3c2;
            border-radius: 0.4rem;
            font: inherit;
            color: inherit;
            background: #ffffff;
        }

        input:focus {
            outline: 3px solid rgb(38 107 255 / 20%);
            border-color: #266bff;
        }

        input[aria-invalid="true"] {
            border-color: #b42318;
        }

        .error-summary {
            margin-bottom: 1.5rem;
            padding: 0.875rem 1rem;
            border-radius: 0.4rem;
        }

        .error-summary {
            color: #7a271a;
            background: #fef3f2;
            border: 1px solid #fecdca;
        }

        .error-summary p {
            margin: 0 0 0.5rem;
            font-weight: 700;
        }

        .error-summary ul {
            margin: 0;
            padding-left: 1.25rem;
        }

        .error {
            display: block;
            margin-top: 0.35rem;
            color: #b42318;
            font-size: 0.9rem;
        }

        .result-status {
            margin: 1.5rem 0;
            padding: 1.25rem;
            border-radius: 0.5rem;
        }

        .result-status.due {
            color: #7a271a;
            background: #fef3f2;
            border: 1px solid #fecdca;
        }

        .result-status.not-due {
            color: #05603a;
            background: #ecfdf3;
            border: 1px solid #abefc6;
        }

        .result-status h2 {
            margin: 0 0 0.5rem;
            font-size: 1.35rem;
        }

        .result-status p,
        .result-status ul {
            margin-top: 0;
            margin-bottom: 0;
        }

        .result-status ul {
            padding-left: 1.25rem;
        }

        dl {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 0.75rem 1.5rem;
            margin: 0 0 2rem;
        }

        dt {
            color: #586174;
        }

        dd {
            margin: 0;
            font-weight: 700;
            text-align: right;
        }

        button,
        .button {
            display: block;
            width: 100%;
            padding: 0.8rem 1rem;
            border: 0;
            border-radius: 0.4rem;
            font: inherit;
            font-weight: 700;
            color: #ffffff;
            background: #1d4ed8;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
        }

        button:hover,
        .button:hover {
            background: #1e40af;
        }

        button:focus-visible,
        .button:focus-visible {
            outline: 3px solid rgb(38 107 255 / 30%);
            outline-offset: 2px;
        }
    </style>
</head>
<body>
    <main>
        @yield('content')
    </main>
</body>
</html>
