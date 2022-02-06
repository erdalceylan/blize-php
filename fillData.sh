#!/bin/bash

bin/console doctrine:fixtures:load
bin/console fill:mongo-messages
bin/console fill:mongo-stories


