
<?php

class BookOption
{
    private PDO $pdo;

    // Receive the database connection
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Get all active customization options for a book
    public function getByBookId(int $bookId): array
    {
        $sql = "
            SELECT
                id,
                book_id,
                option_type,
                option_name,
                price_adjustment
            FROM book_options
            WHERE book_id = :book_id
              AND is_active = 1
            ORDER BY sort_order ASC
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'book_id' => $bookId
        ]);

        $options = $stmt->fetchAll();

        // Group options by their category
        $groupedOptions = [];

        foreach ($options as $option) {

            $type = $option['option_type'];

            $groupedOptions[$type][] = $option;

        }

        return $groupedOptions;
    }
}

?>
