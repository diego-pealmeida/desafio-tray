<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório Diário de Vendas</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f8;
            color: #333;
            padding: 30px;
        }
        .container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 30px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #2c3e50;
            font-size: 24px;
            margin-bottom: 5px;
        }
        .header p {
            font-size: 14px;
            color: #777;
        }
        .greeting {
            font-size: 16px;
            margin-bottom: 20px;
        }
        .summary {
            background-color: #f0f3f5;
            border-radius: 6px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .summary h2 {
            font-size: 18px;
            color: #34495e;
            margin-bottom: 10px;
        }
        .summary-item {
            margin: 8px 0;
            font-size: 16px;
        }
        .footer {
            font-size: 13px;
            color: #999;
            text-align: center;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📊 Relatório Diário de Vendas</h1>
            <p>Resumo das vendas do dia</p>
        </div>

        <div class="greeting">
            Olá, <strong>{{ $name }}</strong>!<br><br>
            Esperamos que esteja tendo um ótimo dia. Aqui está o resumo das vendas efetuadas do dia {{ $report->date }}:
        </div>

        <div class="summary">
            <h2>Resumo de Vendas</h2>
            <div class="summary-item">
                🛒 <strong>Total de Vendas Realizadas:</strong> {{ $report->quantity }}
            </div>
            <div class="summary-item">
                💰 <strong>Valor Total Faturado:</strong> {{ $report->total }}
            </div>
            <div class="summary-item">
                🎯 <strong>Valor Total de Comissão Paga:</strong> {{ $report->total_comission }}
            </div>
        </div>

        <div class="greeting">
            Continue com o excelente trabalho! 💪<br>
            Caso tenha dúvidas ou precise de suporte, estamos aqui para ajudar.
        </div>

        <div class="footer">
            Este é um e-mail automático, por favor não responda diretamente.
        </div>
    </div>
</body>
</html>
