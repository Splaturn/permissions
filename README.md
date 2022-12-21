# splaturn/permissions

Splaturn内部で使用されている許可管理ライブラリです。
クラスベースでの許可実装を助けるためのものです。

## usage

まず、許可の一覧を`splaturn\permissions\PermissionsLayer`を実装したクラスにより定義します。
クラスはプロパティの型がすべて`bool`である必要があります。
また、デフォルト値を持ってもなりません。

これらの仕様を満たしているかを確認するのに`splaturn\permissions\PermissionsValidator`が使用できます。  
テストなどで用いると良いでしょう。

- Good
    ```php
    use splaturn\permissions\PermissionsLayer;

    class YourPermissionLayer implements PermissionsLayer{
        public bool $takeItem;
        public bool $dropItem;
    }
    ```

- Bad
    ```php
    use splaturn\permissions\PermissionsLayer;

    class YourPermissionLayer implements PermissionsLayer{
        public ?bool $takeItem; // must not be nullable
        public string $dropItem; // must not be types other than bool
        public bool $useItem = false; // must not have default value 
    }
    ```

許可の計算をするには`splaturn\permissions\PermissionsCalculator::calculate()`を使用します。

最初のパラメータはベースとなる許可レイヤー(PermissionsLayers)です。
このレイヤーは**すべての**プロパティが定義されている必要があります。

二つ目のパラメータはベースの上に重ねられるレイヤーの配列です。
定義されている中で一番先頭の値が結果に入れられます。

上で定義した`YourPermissionsLayer`を例にします。
```php
use splaturn\permissions\PermissionsCalculator;
/** 
 * @var YourPermissionsLayer[] $layers
 * @var YourPermissionsLayer $base
 **/
$result = PermissionsCalculator::calculate($base, $layers);
```
| layer | takeItem           | dropItem           |
|-------|--------------------|--------------------|
| 1     |                    | :white_check_mark: |
| 2     | :x:                |                    |
| 3     | :white_check_mark: |                    |
| base  | :x:                | :x:                |

このような場合、`$result->takeItem`は`false`、`$result->takeItem`は`true`となります。

上から覗いて見たときに一見えているものが採用されるということです。