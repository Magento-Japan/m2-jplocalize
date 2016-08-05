<?php
\Magento\Framework\Component\ComponentRegistrar::register(
    \Magento\Framework\Component\ComponentRegistrar::MODULE,
    'Veriteworks_Region',
    __DIR__ . '/region'
);
\Magento\Framework\Component\ComponentRegistrar::register(
    \Magento\Framework\Component\ComponentRegistrar::MODULE,
    'Veriteworks_Kana',
    __DIR__ . '/kana'
);
\Magento\Framework\Component\ComponentRegistrar::register(
    \Magento\Framework\Component\ComponentRegistrar::MODULE,
    'Veriteworks_Price',
    __DIR__ . '/price'
);
