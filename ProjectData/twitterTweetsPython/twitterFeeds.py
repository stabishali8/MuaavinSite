# -*- coding: utf-8 -*-
"""

@author: Tabish Ali
"""

# -*- coding: utf-8 -*-
"""

"""
#mysql import
import mysql.connector

#http://www.tweepy.org/
import tweepy

#Get your Twitter API credentials and enter them here
consumer_key = "sqx7UJ2qgzn8pExIzveURNAKL"
consumer_secret = "aLsG0aw1U1QrQPnFwPQCeHQ37eVTv6EXTvIRIgFb9T8DvwhAd0"
access_key = "2825706398-ysrFLTQnIi1VlKfCGoDwnGEKmxIlvmdCFgJxePs"
access_secret  = "ZCS9PNpjlumgNsv0xR08dt6MbECQnLdAz3sEfdP0BNBvV"

#method to get a user's last 10 tweets
def get_tweets():
#    username=khiTraffic;
#   username=ktrafficpolicee;
    cnx = mysql.connector.connect(user="root", password="test", host="127.0.0.1", port="3306", database='muaavin')
    cursor=cnx.cursor()
    auth = tweepy.OAuthHandler(consumer_key, consumer_secret)
    auth.set_access_token(access_key, access_secret)
    api = tweepy.API(auth) 
    
    number_of_tweets = 10
    
    #get tweets
    tweets = api.user_timeline(screen_name = 'khiTraffic',count = number_of_tweets)
    
    #create array of tweet information: username, tweet id, date/time, text
    tweets_for_csv = [['khiTraffic',tweet.id_str, tweet.created_at, tweet.text.encode("utf-8")] for tweet in tweets]
    i=0
    while i<len(tweets_for_csv):
        cursor.execute("Insert into twitter(created_at, tweet) values (%s,%s)",(tweets_for_csv[i][2],tweets_for_csv[i][3]))
        i+=1
    cnx.commit()

    #another account
    #get tweets
    tweets = api.user_timeline(screen_name = 'ktrafficpolicee',count = number_of_tweets)
    
    #create array of tweet information: username, tweet id, date/time, text
#    print(tweets[0][1])
    tweets_for_csv = [['ktrafficpolicee',tweet.id_str, tweet.created_at, tweet.text.encode("utf-8")] for tweet in tweets]
    i=0
    while i<len(tweets_for_csv):
        cursor.execute("Insert into twitter(created_at, tweet) values (%s,%s)",(tweets_for_csv[i][2],tweets_for_csv[i][3]))
        i+=1
    cnx.commit()
    #delete redundant
    cursor.execute("DELETE FROM twitter WHERE id NOT IN (select minid from (SELECT MIN(id) as minid FROM twitter GROUP BY tweet) e);")
    cnx.commit()

#if we're running this as a script
if __name__ == '__main__':
		get_tweets()