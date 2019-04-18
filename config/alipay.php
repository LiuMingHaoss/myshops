<?php
return [
    //应用ID,您的APPID。
    'app_id' => "2016092500595729",

    //商户私钥
    'merchant_private_key' => "MIIEogIBAAKCAQEA2mwOX1SIBApQbyDgsIA7/eWx4HlKxCXlq5KI97KIFSjSZmVKK4eBU5fVHrl/RyLKVJlRsNXuOhgxxzV0PHLuZ5zjtkVQvph4kmW72LuHcdBlwQVCmbbejr+2Qw4tTSjvVBJUoDbIHechAebHwwjPERkh63BIFY2BhmHskU5MTG73EdeXbxeG26h1xi5iThKjQ1dcDi0XxCT09hCAfuKecz/os5NlOqrn0M0mzGe+R/ceQURORFoWePxe+95BwUi1xDkxpPQcasj5sCmqEtdqtP1kNUYxX3BCJdVFf/mlhnzn1LIofzcbTmDDOBCExIQsEjpqKmujs/GErMU8tRDcrQIDAQABAoIBAGBOBIhD3TTq10woUul/oPPxstwmnrCdhQaBNaMBNL8foKVFQ86tkHgrGezSHSxgSpXChCJUMRWsVUZgaz+77SICKuTS6yceUws5j/mftbiZCkRw7UyZNMf7/4DRX2gGBIAtFOMPRGzq28La3nlACQyg6DPG7gGSwuldg9ENlNadxgoWHmkNmNmZi1KRSY5GnEz8Ez9OUVwZ7kMASBtpz9pCgUZ0OJiXNcESWEItAptQUrAeC0OGgS49IJwxE9U/LTe50zwApVfOcM5WJaIBnu5AN4nC1dpIqJDuwlSQAJDZEEhFHHWVOfEEiRS28lEkCv+ql74kLJ2qaSFX9TcvfAECgYEA7oO3NlQzsAztsz9QCikEaLESjYXureeJfshiYhDo1bClHiOmxeiSbqSB10WKKMQYZaDAgaaapTv2CkPZ26SBaqWZGRF0oFT5YRa/+fVoKh08dhsUv7I9XbcNRgao+PTsAv5J5gSWkBwSX8iwP9Qcba64g399WoSj8+D4M1R/zckCgYEA6m9CUu/5ptUWSV2B9TUSYzjAIIEkd6kxn+FKOoi/2bvr6WJfu0YMcHPyomkNK2mez02Vs17v4QlxXLdLIbunPHVQVeb0RkmEG+NYN7J9s9YhjVcyA7RMql9EAALu9o3v2y/NtekJBHqcr8GXNLU9QMP9TKZuVRNQ6EsVIQ6X+cUCgYBot1Fnu94ZjAOML97PJyT1ZdCUa9nXZhEapZV0IqJmtzA3JEXjG/G2O+l5fuFidn2TmNkL0v6QTtv9s75hTT84eE3YEK7YeZYnRxqv/ktmOgHChK8+Xl3M2EIunVvwOW+o/MWrBBaqXHjArtaan2B/0zbVHNMHO7bTqtCtkIqv6QKBgDNsxHe8/F6ET6c4Q9GuGqJ5SGvY6E73ZlNT8Bx28t6oQk+nrKg/7WqdhJPrx1/Gg3el5Ti7kpMipyNXcbusljrE4SJ2zw68Aaa8cBWHqdtRFXsTrXzyh/63dwspmZGsAPlruww0Wi4JV2WWaby+JPmYBHBT8c/ntM+/6JqfwOahAoGASUvHt2+iPd7ZfzOK1xQh7WpIp+0D4NmEuZSpKOeJ/TLoEzfg/iPBX85aIMxbbQmJtq58R04WiSMZKqBGk/Yp50VIwXBLnz5L4OIBtDAzgMorums0ssQ4db80DX47yq2TO3D58Jes4RziQR8D47OMT7nIkR0f7xRqENNdxLZmJKI=",

    //异步通知地址
    'notify_url' => "http://www.myshops.com/notifypay",

    //同步跳转
    'return_url' => "http://www.myshops.com/returnpay",

    //编码格式
    'charset' => "UTF-8",

    //签名方式
    'sign_type'=>"RSA2",

    //支付宝网关
    'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

    //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
    'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAtkxPTCEJSaXMafDd8tckqkhDNnDWImBvu5nqd8AKH5i0cOW+tuwN7oBAbfxeUnsP0yng2aEZVpVrzYWVQDsI2v/0nlTDQemSlFKNTqA71VARJuame49ZR7CL240djkfkYzkYL3BmNlbSwue0G/t8uAPy6gb0Kbf1I36jj/PKAKoYAEZaQRbPn9a7Z92SbN9n8yKGQ3baBm7hakBL7bqi/hInzu90rJbeFZeqoS0I3MlhUhkt5hj7cCkAZtb7lopeZR7PHiHBIv0CFekb9xKP4xdBwFifhrjaG2H0GG7h12h7+4kkvWeTB1DmF5JqCBJOR8JKOJ2A9jzgavaJ5JBS4QIDAQAB",
];