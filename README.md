# CorreiosAPI - Wrapper for Correios' webservices (Brazilian Postal Service)
[![Build Status](https://travis-ci.org/guhemama/CorreiosAPI.svg?branch=master)](https://travis-ci.org/guhemama/CorreiosAPI)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/guhemama/CorreiosAPI/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/guhemama/CorreiosAPI/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/guhemama/CorreiosAPI/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/guhemama/CorreiosAPI/?branch=master)
![Made With Love](https://img.shields.io/badge/made%20with-❤-red.svg)

CorreiosAPI is a small wrapper that let's you query the Correios tracking webservices without
having to know its intricacies (and having to touch XML! ;).


## Requirements
* PHP >= 5.6
* curl


# Install
Install it with Composer:

``` sh
composer require guhemama/correios_api
```

# Usage
You'll need valid credentials to use the Correios webservices. If you do not have
these credentials, you can use a service such as [CorreiosTracker](https://correios.website).

``` php

use CorreiosAPI\Tracker;

$tracker = new Tracker('username', 'password');

try {
  $response = $tracker->track('DU030746105BR');
} catch (\InvalidArgumentException $e) {
  // An invalid tracking number will throw an exception
} catch (\RuntimeException $e) {
  // A HTTP error or XML parsing error will throw an exception
}

print_r($response);
/*
Array
(
  [DU030746105BR] => Array
  (
    [0] => Array
    (
        [when] => 10/12/2015 16:12
        [where] => CDD REBOUCAS - Curitiba/PR
        [action] => Entregue
        [details] => Objeto entregue ao destinatário
    )
    [1] => Array
    (
        [when] => 10/12/2015 10:10
        [where] => CDD REBOUCAS - Curitiba/PR
        [action] => Saiu para entrega
        [details] => Objeto saiu para entrega ao destinatário
    )
    [2] => Array
        (
            [when] => 10/12/2015 08:30
            [where] => CTE CURITIBA - Curitiba/PR
            [action] => Encaminhado
            [details] => Objeto encaminhado
        )
    [3] => Array
    (
        [when] => 08/12/2015 21:30
        [where] => CTE BELO HORIZONTE - BELO HORIZONTE/MG
        [action] => Encaminhado
        [details] => Objeto encaminhado
    )
    [4] => Array
    (
        [when] => 07/12/2015 17:14
        [where] => AC SHOPPING DIVINOPOLIS - Divinopolis/MG
        [action] => Encaminhado
        [details] => Objeto encaminhado
    )
    [5] => Array
    (
        [when] => 07/12/2015 13:57
        [where] => AC SHOPPING DIVINOPOLIS - Divinopolis/MG
        [action] => Postado
        [details] => Objeto postado
    )
  )
)
 */
```


# License

Copyright (c) 2014, Gustavo Henrique Mascarenhas Machado
All rights reserved.

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions are met:

* Redistributions of source code must retain the above copyright notice, this
  list of conditions and the following disclaimer.

* Redistributions in binary form must reproduce the above copyright notice,
  this list of conditions and the following disclaimer in the documentation
  and/or other materials provided with the distribution.

* Neither the name of CorreiosAPI nor the names of its
  contributors may be used to endorse or promote products derived from
  this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE
FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.