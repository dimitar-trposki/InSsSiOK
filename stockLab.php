<?php

class StockPrice
{

    protected $date;
    protected $closed_price;
    protected $opened_price;
    protected $highest_price;
    protected $lowest_price;

    /**
     * @param $date
     * @param float $closed_price
     * @param float $opened_price
     * @param float $highest_price
     * @param float $lowest_price
     */
    public function __construct($date, $closed_price, $opened_price, $highest_price, $lowest_price)
    {
        $this->date = $date;
        $this->closed_price = $closed_price;
        $this->opened_price = $opened_price;
        $this->highest_price = $highest_price;
        $this->lowest_price = $lowest_price;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    public function getClosedPrice()
    {
        return $this->closed_price;
    }

    public function setClosedPrice($closed_price): void
    {
        $this->closed_price = $closed_price;
    }

    public function getOpenedPrice()
    {
        return $this->opened_price;
    }

    public function setOpenedPrice($opened_price): void
    {
        $this->opened_price = $opened_price;
    }

    public function getHighestPrice()
    {
        return $this->highest_price;
    }

    public function setHighestPrice($highest_price): void
    {
        $this->highest_price = $highest_price;
    }

    public function getLowestPrice()
    {
        return $this->lowest_price;
    }

    public function setLowestPrice($lowest_price): void
    {
        $this->lowest_price = $lowest_price;
    }

}

enum SectorType: string
{
    case TECHNOLOGY = 'technology';
    case FINANCE = 'finance';
    case HEALTHCARE = 'healthcare';
    case ENERGY = 'energy';
}

class Stock
{

    protected $ticker;
    protected $shares_outstanding;
    protected $sector;
    protected $stock_prices = [];

    /**
     * @param string $ticker
     * @param int $shares_outstanding
     * @param SectorType $sector
     * @param array $stock_prices
     */
    public function __construct($ticker, $shares_outstanding, $sector, $stock_prices)
    {
        $this->ticker = $ticker;
        $this->shares_outstanding = $shares_outstanding;
        $this->sector = $sector;
        $this->stock_prices = $stock_prices;
    }

    public function addStockPrice($stockPrice): void
    {
        $date = $stockPrice->getDate();
        if (isset($this->stock_prices[$date])) {
            echo "There is already a historical price for this date for this stock\n";
        } else {
            $this->stock_prices[$date] = $stockPrice;
        }
    }

    public function calculateMarketCapForDate($date): ?float
    {
        if (!isset($this->stock_prices[$date])) {
            echo "No historical price for this date for this stock\n";
            return null;
        }
        $stockPrice = $this->stock_prices[$date];
        return $this->shares_outstanding * $stockPrice->getClosedPrice();
    }

    public function getLastClosedPrice(): ?float
    {
        $lastDate = array_key_last($this->stock_prices);
        if ($lastDate === null) {
            return null;
        }
        return $this->stock_prices[$lastDate]->getClosedPrice();
    }

    public function getTicker()
    {
        return $this->ticker;
    }

    public function setTicker($ticker): void
    {
        $this->ticker = $ticker;
    }

    public function getSharesOutstanding()
    {
        return $this->shares_outstanding;
    }

    public function setSharesOutstanding($shares_outstanding): void
    {
        $this->shares_outstanding = $shares_outstanding;
    }

    public function getSector()
    {
        return $this->sector;
    }

    public function setSector($sector): void
    {
        $this->sector = $sector;
    }

    public function getStockPrices()
    {
        return $this->stock_prices;
    }

    public function setStockPrices($stock_prices): void
    {
        $this->stock_prices = $stock_prices;
    }

}

class StockExchange
{

    protected $exchange_name;
    protected $listed_stocks = [];

    /**
     * @param $exchange_name
     */
    public function __construct($exchange_name)
    {
        $this->exchange_name = $exchange_name;
    }

    public function listStock($stock): void
    {
        $this->listed_stocks[$stock->getTicker()] = $stock;
    }

    public function findStockByTicker($ticker): ?Stock
    {
        if ($this->listed_stocks[$ticker] === null) {
            echo "Stock not found\n";
            return null;
        }
        return $this->listed_stocks[$ticker];
    }

    /**
     * @return mixed
     */
    public function getExchangeName()
    {
        return $this->exchange_name;
    }

    /**
     * @param mixed $exchange_name
     */
    public function setExchangeName($exchange_name): void
    {
        $this->exchange_name = $exchange_name;
    }

    /**
     * @return mixed
     */
    public function getListedStocks()
    {
        return $this->listed_stocks;
    }

    /**
     * @param mixed $listed_stocks
     */
    public function setListedStocks($listed_stocks): void
    {
        $this->listed_stocks = $listed_stocks;
    }

}

class Portfolio
{

    protected $cash;
    protected $stockHoldings = [];

    /**
     * @param $cash
     */
    public function __construct($cash)
    {
        $this->cash = $cash;
    }

    public function buyStock($ticker, $numberOfShares, $stockExchange): void
    {
        $stock = $stockExchange->getStockByTicker($ticker);

        if ($stock === null) {
            echo "Stock not found\n";
            return;
        }

        $price = $stock->getLastClosedPrice();
        if ($price === null) {
            echo "No price available for this stock\n";
            return;
        }

        $totalCost = $price * $numberOfShares;
        if ($this->cash < $totalCost) {
            echo "Insufficient cash to buy this stock\n";
            return;
        }

        $this->cash -= $totalCost;
        $this->stockHoldings[] = ['numberOfShares' => $numberOfShares, 'stock' => $stock];
        echo "Sold $numberOfShares shares of $ticker for " . ($price * $numberOfShares) . " USD on {$stockExchange->getExchangeName()}\n";
    }

    /**
     * @return mixed
     */
    public function getCash()
    {
        return $this->cash;
    }

    /**
     * @param mixed $cash
     */
    public function setCash($cash): void
    {
        $this->cash = $cash;
    }

    public function getStockHoldings(): array
    {
        return $this->stockHoldings;
    }

    public function setStockHoldings(array $stockHoldings): void
    {
        $this->stockHoldings = $stockHoldings;
    }

}

$applePrice1 = new StockPrice('01/01/2025', 100.0, 95.0, 102.0, 90.0);
$applePrice2 = new StockPrice('02/01/2025', 110.0, 100.0, 115.0, 98.0);
$applePrice3 = new StockPrice('03/01/2025', 120.0, 112.0, 125.0, 110.0);

$appleStock = new Stock('AAPL', 16000000000.0, Sector::TECHNOLOGY);
$appleStock->addStockPrice($applePrice1);
$appleStock->addStockPrice($applePrice2);
$appleStock->addStockPrice($applePrice3);

$microsoftStock = new Stock('MSFT', 7500000000.0, Sector::TECHNOLOGY);
$microsoftStock->addStockPrice(new StockPrice('01/01/2025', 300.0, 295.0, 310.0, 290.0));

$nasdaq = new StockExchange('NASDAQ');
$nasdaq->listStock($appleStock);
$nasdaq->listStock($microsoftStock);

echo "MarketCap 02/01/2025: ".($appleStock->calculateMarketCapForDate('02/01/2025') ?? 'null')." USD\n";

$portfolio = new Portfolio(10000.0);
$portfolio->buyStock('AAPL', 10, $nasdaq);
$portfolio->buyStock('MSFT', 5, $nasdaq);
$portfolio->buyStock('MSFT', 1000, $nasdaq);
$portfolio->sellStock('AAPL', 4, $nasdaq);
$portfolio->sellStock('MSFT', 50, $nasdaq);

echo "Cash: {$portfolio->cashBalance} USD\n";
print_r($portfolio->stockHoldings);